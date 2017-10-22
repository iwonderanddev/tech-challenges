import React from 'react'
import { Row, Col } from 'antd';

import SurveysList from '../../components/SurveysList/SurveysList'

require('./surveys.css');
export const Surveys = props => (
    <div class="survey-page">
        <Row>
            <Col>
                <h1>Surveys</h1>
            </Col>
        </Row>
        <Row>
            <Col>
                <SurveysList />
            </Col>
        </Row>
    </div>
)
