import React from 'react'
import { Link } from 'react-router-dom'
import { Button, Icon } from 'antd';

import { connect } from 'react-redux'

import './home.css';


export const Home = props => (
<div className="home-page">
<h1>Home</h1>
<p>Welcome to the Survey Viewer App !</p>
    <Button type="primary">
      <Link to='surveys'>Browse Surveys<Icon type="right" /></Link>
    </Button>
</div>
)
