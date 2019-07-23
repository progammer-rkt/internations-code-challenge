import React from 'react';
import PropTypes from 'prop-types';
import Col from 'react-bootstrap/Col';

function PageTitle({ title, subtitle, ...attrs }) {
  return (
    <Col xs="12" sm="4" className="text-center text-md-left mb-sm-0" {...attrs}>
      <span className="text-uppercase page-subtitle">{subtitle}</span>
      <h3 className="page-title">{title}</h3>
    </Col>
  );
}

PageTitle.propTypes = {
  /**
   * The page title.
   */
  title: PropTypes.string,
  /**
   * The page subtitle.
   */
  subtitle: PropTypes.string
};

export default PageTitle;
