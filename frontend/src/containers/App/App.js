import React from 'react';
import { Route, Link } from 'react-router-dom'
import Home from '../Home'
import About from '../About'
import {Surveys} from '../Surveys'
import {SurveyView} from '../SurveyView'

export const App = () => (
    <div>
        <header>
            <Link to="/">Home</Link>
            <Link to="/surveys">Surveys</Link>
            <Link to="/about">About</Link>
        </header>

        <main>
            <Route exact path="/" component={Home} />
            <Route exact path="/surveys" component={Surveys} />
            <Route exact path="/about" component={About} />
            <Route exact path="/surveys/:id" component={SurveyView} />
        </main>
    </div>
)
