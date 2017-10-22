import React from 'react'
import { Row, Col, Card } from 'antd';

require('./about.css');

export default () => (
    <div className="about-page">
        <h1>Tech</h1>
        <Row gutter={16}>
            <Col span={8}>
                <Card title="React" bordered={false}>View Framework</Card>
            </Col>
            <Col span={8}>
                <Card title="Redux" bordered={false}>State Management</Card>
            </Col>
            <Col span={8}>
                <Card title="Axios" bordered={false}>Request/Async handling</Card>
            </Col>
            <Col span={8}>
                <Card title="Sass" bordered={false}>Stylesheet Language</Card>
            </Col>
            <Col span={8}>
                <Card title="Amcharts" bordered={false}>Charts Library</Card>
            </Col>
        </Row>
    </div>
)
