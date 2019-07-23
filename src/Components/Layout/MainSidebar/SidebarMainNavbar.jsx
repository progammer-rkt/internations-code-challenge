import React from 'react';
import PropTypes from 'prop-types';
import { withRouter } from 'react-router-dom';
import Navbar from 'react-bootstrap/Navbar';
import NavbarBrand from 'react-bootstrap/NavbarBrand';

import dashboardLogo from '../../../images/shards-dashboards-logo.svg';

// import { Dispatcher, Constants } from "../../../flux";

class SidebarMainNavbar extends React.Component {
  constructor(props) {
    super(props);
    this.click = this.click.bind(this);
  }

  click(event) {
    event.preventDefault();
    const { history } = this.props;
    history.push('/dashboard');
  }

  render() {
    const { hideLogoText } = this.props;
    return (
      <div className="main-navbar">
        <Navbar
          className="align-items-stretch bg-white flex-md-nowrap border-bottom p-0"
          type="light"
        >
          <NavbarBrand
            className="w-100 mr-0"
            href="#"
            style={{ lineHeight: '25px' }}
          >
            <div className="d-table m-auto" onClick={this.click}>
              <img
                id="main-logo"
                className="d-inline-block align-top mr-1"
                style={{ maxWidth: '25px' }}
                src={dashboardLogo}
                alt="Shards Dashboard"
              />
              {!hideLogoText && (
                <span className="d-none d-md-inline ml-1">Admin Dashboard</span>
              )}
            </div>
          </NavbarBrand>
          {/* eslint-disable-next-line */}
          <a
            className="toggle-sidebar d-sm-inline d-md-none d-lg-none"
            onClick={this.handleToggleSidebar}
          >
            <i className="material-icons">&#xE5C4;</i>
          </a>
        </Navbar>
      </div>
    );
  }
}

SidebarMainNavbar.propTypes = {
  /**
   * Whether to hide the logo text, or not.
   */
  hideLogoText: PropTypes.bool
};

SidebarMainNavbar.defaultProps = {
  hideLogoText: false
};

export default withRouter(SidebarMainNavbar);
