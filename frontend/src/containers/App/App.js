import React from 'react';
import { Route, Link } from 'react-router-dom'
import Button from 'antd/lib/button';
import './app.css';


import {Home} from '../Home/Home'
import About from '../About/About'
import {AppMenu} from '../Menu';
import {Surveys} from '../Surveys/Surveys'
import {SurveyView} from '../SurveyView/SurveyView'

export const App = () => (
    <div>
        <AppMenu />

        <main>
            <Route exact path="/" component={Home} />
            <Route exact path="/surveys" component={Surveys} />
            <Route exact path="/about" component={About} />
            <Route exact path="/surveys/:id" component={SurveyView} />
        </main>
    </div>
)
