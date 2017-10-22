<?php

namespace IWD\JOBINTERVIEW\Api;

use Silex\Application;
use IWD\JOBINTERVIEW\Controller\SurveyApiController;

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
        $this->app['survey.api.controller'] = function() {
            return new SurveyApiController();
        };
    }
    /**
     * bin routes to our controller actions
     */
    public function bindRoutesToControllers()
    {
        $this->app->get('/api/surveys/', "survey.api.controller:getSurveys");
        $this->app->get('/api/raw', "survey.api.controller:getRawData");
        $this->app->get('/api/surveys/{id}', "survey.api.controller:getSurvey");
    }
}