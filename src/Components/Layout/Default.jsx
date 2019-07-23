import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

import MainSidebar from './MainSidebar';
import MainFooter from './MainFooter';
import { Loader } from '../Common';
import '../../css/dashboard.css';

function DefaultLayout({ children, loader }) {
  return (
    <Container fluid>
      <Row>
        <MainSidebar />
        <Col
          className="main-content p-0 ml-0"
          lg={{ size: 10, offset: 2 }}
          md={{ size: 9, offset: 3 }}
          sm="12"
          tag="main"
        >
          <Loader />
          {loader ? '' : children}
          {loader ? '' : <MainFooter />}
        </Col>
      </Row>
    </Container>
  );
}

DefaultLayout.propTypes = {
  loader: PropTypes.bool.isRequired
};

const mapStateToProps = ({ page }) => ({
  loader: page.loader
});

DefaultLayout.displayName = 'DefaultLayout';

export default connect(mapStateToProps)(DefaultLayout);
