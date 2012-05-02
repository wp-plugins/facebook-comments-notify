<?php
/*
 * Plugin Name:  Facebook Comments Notify
 * Requires at least: 3.2.1
 * Tested up to: 3.2.2
 * Stable tag: 0.2
 * Description:  Full Facebook Comments moderation and management for your WordPress site. Quick and easy to set up. Insert automatically or via a shortcode.
 * Version: 0.2
 * Author:       Ramon Vicente
 * Author URI:   http://ramonvic.com.br/
 * Contributors: Ramon Vicente
 * Link: http://wordpress.org/extend/plugins/facebook-comments-notify/
 * Tags: comments, facebook, facebook comments, commenting, notify, notify comments, notification
 * License: GPLv3
 */

if (! defined('FBCOMMENTS_VERSION')) {
    define('FBCOMMENTS_VERSION', '0.1');
}
define('FBCOMMENTS_ABSPATH', dirname(__FILE__));
define('FBCOMMENTS_RELPATH', plugins_url() . '/' . basename(FBCOMMENTS_ABSPATH));


wp_enqueue_script('jquery');
add_action('init', array('FBNotify', 'init'));

global $fbcomment_default_options;

$fbcomment_default_options = array(
    'use_fbml' => 1,
    'use_fbns' => 0,
    'use_opengraph' => 1,
    'use_html5' => 0,
    'in_posts' => 1,
    'in_pages' => 0,
    'in_homepage' => 0,
    'app_id' => '',
    'language' => 'pt_BR',
    'number' => '5',
    'title' => 'Comments',
    'show_count' => 1,
    'count_text' => 'Comments',
    'notification_active' => 0,
    'use_smtp' => 1,
    'notification_use_gmail' => 0,
    'email_host' => '',
    'email_port' => '',
    'email_secure_type' => '',
    'email_auth' => 0,
    'email_username' => '',
    'email_password' => '',
    'email_to_send' => '', 
    'email_text_to_send' => '<p>Novo Comentário na página <a href="#HREF#">#HREF#</a></p>', 
    'scheme' => 'light',
    'width' => '450',
);

class FBNotify {
    static $_instance;
    private $options;
    private $_postID;
    
    public function __construct(){}
    
    public function init(){
        global $fbcomment_options, $fbcomment_default_options;
        
        add_option('fbComments', $fbcomment_default_options);
        $fbcomment_options = get_option('fbComments');
        add_action('admin_menu', array('FBNotify', 'admin_menu')); //Adiciona Link para as Configuraçoes
        add_action('wp_head', array('FBNotify', 'add_meta_app_id')); //Add app_ID meta_tag on wp_head
        add_filter('language_attributes', array('FBNotify', 'add_name_space')); //Adiciona os namespaces a tag html
        
        add_action('wp_footer', array('FBNotify', 'addscript'), 100);
        add_action('wp_footer', array('FBNotify', 'add_script_notification'), 100);
        add_filter('the_content', array('FBNotify', 'comment_box'), 100);
        
        add_action('wp_ajax_nopriv_send_comment_notification', array('FBNotify', 'send_notification'));
        add_action('wp_ajax_send_comment_notification', array('FBNotify', 'send_notification'));
        
        
        add_filter('widget_text', array('FBNotify', 'do_shortcode'), 100);
        add_shortcode('fbcomments', array('FBNotify', 'add_shortcode'), 100);

    }
    
    /**
     * Adiciona Caminho no Menu para as Configuracoes do Plugin
     * @return void
     */
    public function admin_menu(){ 
        add_options_page(
            __('Facebook Comments Notify'), 
            __('Facebook Comments'), 
            'manage_options', 
            'fbcomments_notify', 
            array('FBNotify', 'options_page')
        );
    }
    
    /**
     * Carrega a Pagina de Configuracao do Plugin
     * @return void
     */
    public function options_page(){
        include FBCOMMENTS_ABSPATH . '/includes/options_page.php';
    }
    
    /**
     * Adiciona a MetaTag fb:app_id na chamada do wp_head
     * @return void
     */
    public function add_meta_app_id (){
        global $fbcomment_options;
        if ($fbcomment_options['app_id'])
            echo "<meta property=\"fb:app_id\" content=\"{$fbcomment_options['app_id']}\"/>\n";
    }
    
    /**
     * Adiciona Namespace a tag html
     * @param String $attr
     * @return $attr
     */
    public function add_name_space ($attr){
        global $fbcomment_options;
        if ($fbcomment_options['use_opengraph']) {
            $attr .= " xmlns:og=\"http://ogp.me/ns#\"";
        }
        if ($fbcomment_options['use_fbns'] && $fbcomment_options['use_html5']) {
            $attr .= " xmlns:fb=\"http://ogp.me/ns/fb#\"";
        }
        return $attr;
    }
    
    /**
     * Adiciona link para o script global do facebook
     * @return void
     */
    public function addscript (){
        global $fbcomment_options;
        echo "\n<div id=\"fb-root\" style=\"display: none;\"></div>\n";
        echo "<script src='//connect.facebook.net/{$fbcomment_options['language']}/all.js#appId={$fbcomment_options['app_id']}&amp;xfbml=1' type='text/javascript'></script>\n";
    }
    
    /**
     * Adiciona o Script de Notificacao junto ao script do facebook
     * @return void
     */
    public function add_script_notification(){
        global $fbcomment_options;
        $postID = self::getInstance()->_postID;
        
        echo "<script type=\"text/javascript\">
                FB.Event.subscribe('comment.create', function(a) {";        
        if($fbcomment_options['notification_active'] && $fbcomment_options['email_to_send'])
            echo " jQuery.post('" . admin_url() . "admin-ajax.php', {action : 'send_comment_notification', postID : '{$postID}', href : a.href}, function(a){});";
        echo "});</script>";
    }
    
    
    
    /**
     * Adiciona o box de comentarios as paginas utilizando a the_content
     * @param string $content
     * @return string $content
     */
    public function comment_box ($content){
        global $fbcomment_options;
        
        self::getInstance()->_postID = get_the_ID();
        if ((is_single() && $fbcomment_options['in_posts']) || (is_page() && $fbcomment_options['in_pages']) || ((is_home() || is_front_page()) && $fbcomment_options['in_homepage'])) {
            if ($fbcomment_options['show_count'] && $fbcomment_options['count_text'])
                $commentcount = "<p><fb:comments-count href=" . get_permalink() . "></fb:comments-count>{$fbcomment_options['count_text']}</p>";
            
            $content .= "<div class=\"fbcomments_notify\">";
            $content .= $fbcomment_options['title'] ? "<h3>{$fbcomment_options['title']}</h3>" : "";
                
            if ($fbcomment_options['use_html5'])
                $content .= $commentcount . "<div class=\"fbcommentbox\"><div class=\"fb-comments\" notify=\"true\" data-href=\"" . get_permalink() . "\" data-num-posts=\"{$fbcomment_options['number']}\" data-width=\"{$fbcomment_options['width']}\" data-colorscheme=\"{$fbcomment_options['scheme']}\"></div></div>";
            else
                $content .= $commentcount . "<div class=\"fbcommentbox\"><fb:comments notify=\"true\" href=\"" . get_permalink() . "\" num_posts=\"{$fbcomment_options['number']}\" width=\"{$fbcomment_options['width']}\" colorscheme=\"{$fbcomment_options['scheme']}\"></fb:comments></div>";
            $content .= "</div>";
        }
        return $content;
    }
    
    public function send_notification(){
        global $fbcomment_options, $phpmailer;
        ignore_user_abort(true);
        self::setup_mailer();
        $p = $_POST;
        if ($p){
            
            foreach($p as $key=>$value){
                $patterns[] = "/#".strtoupper($key)."#/";
                $replacements[]  = (string)$value;
            }
            
            $message =  preg_replace($patterns, $replacements, $fbcomment_options['email_text_to_send']);
            
            $phpmailer->AddAddress($fbcomment_options['email_to_send']);
            $phpmailer->Subject = __('New comment on site : ') . get_bloginfo('site_name');
            $phpmailer->MsgHTML($message);
            $phpmailer->Send();
            exit();
        }
    }
    
    public function setup_mailer (){
        global $phpmailer, $fbcomment_options;
        
        // Include PHPMailer
        require_once ABSPATH . WPINC . '/class-phpmailer.php';
        require_once ABSPATH . WPINC . '/class-smtp.php';
        
        $phpmailer = new PHPMailer(true);
        
        if ($fbcomment_options['use_smtp']){
            $phpmailer->IsSMTP();
            $phpmailer->SMTPAuth = $fbcomment_options['email_auth'];
            $phpmailer->SMTPSecure = $fbcomment_options['email_secure_type'];
            $phpmailer->Host = $fbcomment_options['email_host'];
            $phpmailer->Port = $fbcomment_options['email_port'];
            $phpmailer->Username = $fbcomment_options['email_username'];
            $phpmailer->Password = $fbcomment_options['email_password'];
            
        }
        $phpmailer->SetFrom(get_bloginfo('admin_email'), get_bloginfo('admin_name'));
        $phpmailer->CharSet = 'utf-8';
    }
    
    public function add_shortcode($fbatts){
        global $fbcomment_options;
        
        extract(shortcode_atts(array(
    		"width" => $fbcomment_options['width'],
    		"show_count" => $fbcomment_options['show_count'],
    		"count_text" => $fbcomment_options['count_text'],
    		"number" => $fbcomment_options['number'],
    		"title" => $fbcomment_options['title'],
    		"migrated" => $fbcomment_options['migrated'],
    		"url" => get_permalink(),
    		"linklove" => $fbcomment_options['linklove'],
    		"scheme" => $fbcomment_options['scheme'],
        ), $fbatts));
        
        if ($migrated)
            $migrate = "migrated=\"1\"";
        
        if ($show_count && $count_text)
            $commentcount = "<p><fb:comments-count href='{$url}'></fb:comments-count>{$count_text}</p>";
        
        $content .= "<div class=\"fbcomments_notify\">";
        $content .= $title ? "<h3>{$title}</h3>" : "";
        
        if ($fbcomment_options['use_html5'])
            $content .= $commentcount . "<div class=\"fbcommentbox\"><div class=\"fb-comments\" notify=\"true\" data-href=\"{$url}\" data-num-posts=\"{$number}\" data-width=\"{$width}\" data-colorscheme=\"{$scheme}\"></div></div>";
        else
            $content .= $commentcount . "<div class=\"fbcommentbox\"><fb:comments notify=\"true\" href=\"{$url}\" num_posts=\"{$number}\" width=\"{$width}\" colorscheme=\"{$scheme}\"></fb:comments></div>";
        
        $content .= "</div>";
        
        return $content;
    }
    
    static function getInstance(){
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }
}