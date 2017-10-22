import { Menu, Icon } from 'antd';
import { Link } from 'react-router-dom'

class Menu extends React.Component {
  handleClick = (e) => {
    console.log('click ', e);
  }
  render() {
    return (
      <Menu
        onClick={this.handleClick}
        selectedKeys={[this.state.current]}
        mode="horizontal"
      >
        <Menu.Item key="home">
          <Link to="/"><Icon type="mail" /> Home</Link>
        </Menu.Item>
        <Menu.Item key="surveys">
          <Link to="/surveys"><Icon type="appstore" /> Surveys</Link>
        </Menu.Item>
        <Menu.Item key="about">
          <Link to="/about">About</Link>
        </Menu.Item>
      </Menu>
    );
  }
}
