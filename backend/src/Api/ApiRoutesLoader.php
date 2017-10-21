<?php

namespace IWD\JOBINTERVIEW\Api;

use Silex\Application;
use IWD\JOBINTERVIEW\Controller\ApiController;

/**
 * Class ApiRoutesLoader
 * @package IWD\JOBINTERVIEW\Api
 *
 * register api routes to our app and bind them to ApiController actions
 */
class ApiRoutesLoader
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    /**
     * register apiController to our app
     */
    private function instantiateControllers()
    {
        $this->app['api.controller'] = function() {
            return new ApiController();
        };
    }
    /**
     * bin routes to our controller actions
     */
    public function bindRoutesToControllers()
    {
        $this->app->get('/api/surveys/all', "api.controller:getSurveys");
        $this->app->get('/api/raw', "api.controller:getRawData");
        $this->app->get('/api/surveys/{id}', "api.controller:getSurvey");
    }
}