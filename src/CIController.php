<?php

namespace diezeel\CI;

use BadMethodCallException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\ControllerMiddlewareOptions;
use MY_Output;
use Nwidart\Modules\Facades\Module;

class CIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Reference to the CI singleton
     *
     * @var    object
     */
    private static $instance;

    /**
     * CI_Loader
     *
     * @var    CI_Loader
     */
    public $load;

    /**
     * The middleware registered on the controller.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {
        self::$instance =& $this;
        global $LOADED;
        foreach ($LOADED as $var => $class) {
            $this->$var =& load_class($class);
        }
        //$this->config = & load_class('Config');
        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();

        /** @author 18e14c93 Ruslan Hleba <gleba.ruslan@gmail.com> on 13.01.2020 at 20:14 */
        $headers = $this->input->request_headers('Authorization');
        if (isset($headers['Authorization']) && $headers['Authorization']) {
            $token = isset($headers['Authorization']) && $headers['Authorization'] ? $headers['Authorization'] : null;
            $tokenParts = explode('.', $token);
            if (isset($tokenParts[1])) {
                $userData = json_decode(base64_decode($tokenParts[1]));

                if (isset($userData->user_id)) {
                    CI::$APP->load->model('mdl_user');
                    $deviceData = CI::$APP->mdl_user->getDeviceByUserAndToken($userData->user_id, $token);

                    if ($deviceData) {
                        $this->user = $userData;
                        $this->token = $token;
                    }
                }
            }
        }

        if ($this->session->userdata('user_id') && strtolower($class) != 'chat') {
            save_log();
        }
        /** end */
        $this->router =& load_class('Router', 'core');

        $namespace = request()->route()->getAction('namespace');
        $namespaceArr = explode('\\', $namespace);
        $this->module = Module::find($namespaceArr[1]);
        $this->load->_ci_set_view_path($this->module->getPath() . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'ci_views' . DIRECTORY_SEPARATOR);
    }

    /**
     * Get the CI singleton
     *
     * @static
     * @return    object
     */
    public static function &get_instance()
    {
        return self::$instance;
    }

    /**
     * @param object $instance
     */
    public static function setInstance(object $instance): void
    {
        self::$instance = $instance;
    }

    public function response($data = [], $httpCode = 200, $display = false)
    {
        /** @var MY_Output $output */
        $output = self::$instance->output
            ->set_content_type('application/json')
            ->set_status_header($httpCode)
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        if ($display) {
            $output->_display();
            exit;
        }
    }

    public function errorResponse($error = null, $errors = [], $httpCode = 200, $display = false)
    {
        $data['status'] = 'error';
        if ($error !== null) {
            $data['error'] = $error;
        }
        if (!empty($errors)) {
            $data['errors'] = $errors;
        }
        return $this->response($data, $httpCode, $display);
    }

    public function successResponse($data = [], $message = null, $httpCode = 200, $display = false)
    {
        $payload['status'] = 'ok';
        if ($message !== null) {
            $payload['message'] = $message;
        }
        return $this->response(array_merge($payload, $data), $httpCode, $display);
    }

    /**
     * Register middleware on the controller.
     *
     * @param \Closure|array|string $middleware
     * @param array $options
     * @return \Illuminate\Routing\ControllerMiddlewareOptions
     */
    public function middleware($middleware, array $options = [])
    {
        foreach ((array)$middleware as $m) {
            $this->middleware[] = [
                'middleware' => $m,
                'options' => &$options,
            ];
        }

        return new ControllerMiddlewareOptions($options);
    }

    /**
     * Get the middleware assigned to the controller.
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * Execute an action on the controller.
     *
     * @param string $method
     * @param array $parameters
     * @return \Inertia\Response
     */
    public function callAction($method, $parameters)
    {
        $return = call_user_func_array([$this, $method], $parameters);

        if(!$return && $this->output){
            if(config('ci.use_inertia')){
                return \Inertia\Inertia::render(config('ci.inertia_component','Old'),[
                    'view' => $this->output
                ]);
            }
            return $this->output->get_output();
        }

        return $return;
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}
