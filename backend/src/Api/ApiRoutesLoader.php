<?php

namespace IWD\JOBINTERVIEW\Api;

use Silex\Application;
use IWD\JOBINTERVIEW\Controller\ApiController;


// unused atm
class ApiRoutesLoader
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }
    private function instantiateControllers()
    {
        $this->app['api.controller'] = function() {
            return new ApiController($this->app['api.jsonapi']);
        };
    }
    public function bindRoutesToControllers()
    {
        $api = $this->app["controllers_factory"];
        $api->get('/api/surveys/all', "controller.apicontroller:getSurveys");
        $api->get('/api/surveys/{id}', "controller.apicontroller:getSurvey");
    }
}