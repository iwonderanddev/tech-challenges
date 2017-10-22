import React from 'react';
import { Menu, Icon } from 'antd';
import { Link } from 'react-router-dom'

export const AppMenu = props => (

      <Menu
        mode="horizontal"
      >
        <Menu.Item key="home">
          <Link to="/"><Icon type="home" /> Home</Link>
        </Menu.Item>
        <Menu.Item key="surveys">
          <Link to="/surveys"><Icon type="notification" /> Surveys</Link>
        </Menu.Item>
        <Menu.Item key="about">
          <Link to="/about"><Icon type="code-o" /> About</Link>
        </Menu.Item>
      </Menu>
);
