<?php
namespace VSTR\Base;

class Ajax{

    protected static $_instance = null;
    private $params = [];
    private $requestType; 
    private $requestMethod;
    private $requestModel;
    private $namespace = 'VSTR\Model\\';
    private $model;


    public function register(){
        add_action('wp_ajax_vstr_ajax', [$this, 'prepareAjax']);
        add_action('wp_ajax_nopriv_vstr_ajax', [$this, 'prepareAjax']);
        add_action('wp_enqueue_scripts', [$this, 'localizeScript']);
        add_action('admin_enqueue_scripts', [$this, 'localizeScript']);
    }

    function localizeScript(){
        $user_meta = get_userdata(get_current_user_id());
        $user_roles = isset($user_meta->roles) ? $user_meta->roles : [];
        $is_admin = in_array('administrator', $user_roles);

        wp_localize_script( 'react', 'bData', [
            'ajaxURL' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_rest'),
            'isAdmin' => $is_admin,
        ] );
    }

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function isset($array, $key, $default = false){
        if(isset($array[$key])){
            return $array[$key];
        }
        return $default;
    }

    public function prepareAjax(){
        if(isset($_GET['token'])){
            $this->params = $_GET;
            $this->requestType = 'POST';
        } else {
            $this->params = $_POST;
            $this->requestType = 'GET';
        }
        echo wp_kses_post( wp_json_encode($this->proceedRequest()));
        die();
    }

    public function proceedRequest(){
        $data = $this->params;
        $token = $this->isset($data, 'token');

        if(!wp_verify_nonce( $token, 'wp_rest' )){
            return new \WP_Error('invalid', 'Invalid Request');
        }
        
        $this->requestModel = $this->isset($data, 'model', 'Model');
        $this->requestMethod = $this->isset($data, 'method', 'invalid');
        $this->model = $this->namespace.$this->requestModel;
        
        unset($this->params['method']);
        unset($this->params['action']);
        unset($this->params['token']);
        unset($this->params['model']);
        
        if(method_exists($this, $this->requestMethod)){
            return new \WP_REST_Response($this->{$this->requestMethod}($this->params), 200);
        }
        
        if(!class_exists($this->namespace.$this->requestModel)){
            return $this->invalid();
        }

        $model = new $this->model();

        if(method_exists($model, $this->requestMethod)){
            return $model->{$this->requestMethod}($this->params);
        }else {
            return new \WP_Error('invalid', 'Invalid Request');
            throw new \Exception(__('Automation is not configured', 'visitor-feedback'));
            return false;
        }
    }

    function getFeedbacks(){
        global $wpdb;
        $table_name = $wpdb->prefix.'vstr_visitor_feedbacks';
        return $wpdb->get_results("SELECT * FROM $table_name");
    }

    function updateFeedback(){
        global $wpdb;
        $table_name = $wpdb->prefix.'vstr_visitor_feedbacks';
        return $wpdb->insert($table_name, $this->params);
    }

    public function invalid(){
       return new \WP_REST_Response('invalid request', 400);
    }

    function getDesignData(){
        return get_option('vstr_settings');
    }
}