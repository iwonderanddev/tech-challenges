import React from 'react'
import { Row, Col } from 'antd';

import SurveysList from '../components/SurveysList/SurveysList'

export const Surveys = props => (
    <div>
        <Row>
            <Col>
                <h1>Surveys</h1>
            </Col>
        </Row>
        <Row>
            <Col span={8}>
                <SurveysList />
            </Col>
        </Row>
    </div>
)
