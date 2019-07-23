import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import {
  updateActiveRightColInUserPage,
  updateActiveUserInUserPage,
  updateActiveUserGroups
} from '../../../../Redux/Actions';
import config from '../../../../Config';
import { fetchUserGroups } from '../../../../Async';

class AssignGroups extends React.Component {
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
      updateActiveRightColInUserPage,
      updateActiveUserGroups
    } = this.props;

    // collect user groups and update redux store
    fetchUserGroups(userId).then(userGroups => {
      updateActiveUserGroups(userGroups);
    });

    updateActiveRightColInUserPage(config.page.users.assignGroupsColumn);
    updateActiveUserInUserPage(`item-${userId}`);
  }

  render() {
    return (
      <a href="#" onClick={this.click}>
        Assign
      </a>
    );
  }
}

AssignGroups.propTypes = {
  userId: PropTypes.number,
  updateActiveRightColInUserPage: PropTypes.func.isRequired,
  updateActiveUserInUserPage: PropTypes.func.isRequired,
  updateActiveUserGroups: PropTypes.func.isRequired
};

AssignGroups.defaultProps = {
  userId: 0
};

const mapDispatchToProps = {
  updateActiveRightColInUserPage,
  updateActiveUserInUserPage,
  updateActiveUserGroups
};

AssignGroups.displayName = 'AssignGroups';

export default connect(
  null,
  mapDispatchToProps
)(AssignGroups);
