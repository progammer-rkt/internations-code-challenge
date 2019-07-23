import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';

import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Nav from 'react-bootstrap/Nav';
import NavItem from 'react-bootstrap/NavItem';
import NavLink from 'react-bootstrap/NavLink';

function MainFooter({ contained, menuItems, copyright }) {
  return (
    <footer className="main-footer d-flex p-2 px-3 bg-white border-top">
      <Container fluid={contained}>
        <Row>
          <Nav>
            {menuItems.map(item => (
              <NavItem key={item.id}>
                <NavLink tag={Link} to={item.to}>
                  {item.title}
                </NavLink>
              </NavItem>
            ))}
          </Nav>
          <span className="copyright ml-auto my-auto mr-2">{copyright}</span>
        </Row>
      </Container>
    </footer>
  );
}

MainFooter.propTypes = {
  /**
   * Whether the content is contained, or not.
   */
  contained: PropTypes.bool,
  /**
   * The menu items array.
   */
  menuItems: PropTypes.array,
  /**
   * The copyright info.
   */
  copyright: PropTypes.string
};

MainFooter.defaultProps = {
  contained: false,
  copyright: 'Copyright © 2019 Rajeev K Tomy',
  menuItems: []
};

export default MainFooter;
