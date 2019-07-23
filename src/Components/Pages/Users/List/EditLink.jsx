import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import {
  updateActiveRightColInUserPage,
  updateActiveUserInUserPage
} from '../../../../Redux/Actions';
import config from '../../../../Config';

class EditLink extends React.Component {
  constructor(props) {
    super(props);
    this.click = this.click.bind(this);
  }

  click(event) {
    event.preventDefault();
    event.stopPropagation();
    const {
      userId,
      updateActiveUserInUserPage,
      updateActiveRightColInUserPage
    } = this.props;
    updateActiveRightColInUserPage(config.page.users.createUserColumn);
    updateActiveUserInUserPage(`item-${userId}`);
  }

  render() {
    return (
      <a href="#" onClick={this.click}>
        Edit
      </a>
    );
  }
}

EditLink.propTypes = {
  userId: PropTypes.number,
  updateActiveRightColInUserPage: PropTypes.func.isRequired,
  updateActiveUserInUserPage: PropTypes.func.isRequired
};

EditLink.defaultProps = {
  userId: 0
};

const mapDispatchToProps = {
  updateActiveRightColInUserPage,
  updateActiveUserInUserPage
};

EditLink.displayName = 'EditUserLink';

export default connect(
  null,
  mapDispatchToProps
)(EditLink);
