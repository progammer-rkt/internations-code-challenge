import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Alert from 'react-bootstrap/Alert';

import { turnOffMessage } from '../../Redux/Actions';
import Config from '../../Config';

class PageMessage extends React.Component {
  constructor(props) {
    super(props);
    this.timer = false;
  }

  componentDidUpdate() {
    const { show, turnOffMessage } = this.props;
    if (show) {
      this.timer = setTimeout(() => {
        turnOffMessage();
      }, 3000);
    } else if (this.timer) {
      clearTimeout(this.timer);
    }
  }

  render() {
    const { show, message, isError } = this.props;
    return (
      <Alert
        show={show}
        className="col-sm-12 col-md-8 offset-md-2"
        variant={isError ? 'danger' : 'success'}
      >
        {message}
      </Alert>
    );
  }
}

PageMessage.propTypes = {
  show: PropTypes.bool.isRequired,
  isError: PropTypes.bool.isRequired,
  message: PropTypes.string.isRequired,
  turnOffMessage: PropTypes.func.isRequired
};

const mapStateToProps = ({ page }) => ({
  show: page.hasMessageAdded,
  isError: page.message.type === Config.message.type.error,
  message: page.message.value || ''
});

const mapDispatchToProps = {
  turnOffMessage
};

PageMessage.displayName = 'PageMessage';

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(PageMessage);
