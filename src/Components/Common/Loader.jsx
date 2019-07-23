import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Spinner from 'react-bootstrap/Spinner';

function Loader({ show }) {
  if (show) {
    return (
      <div
        style={{
          top: '50%',
          left: '50%',
          position: 'absolute',
          zIndex: '1000'
        }}
      >
        <Spinner animation="grow" />
      </div>
    );
  }
  return <React.Fragment />;
}

Loader.propTypes = {
  show: PropTypes.bool.isRequired
};

const mapStateToProps = ({ page }) => ({
  show: page.loader
});

Loader.displayName = 'Loader';

export default connect(mapStateToProps)(Loader);
