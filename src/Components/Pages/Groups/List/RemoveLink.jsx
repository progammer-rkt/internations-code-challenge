import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import {
  updateShowStatusOfCreateGroupForm,
  updateActiveGroupId,
  updateGroupList,
  triggerLoader,
  addPageErrorMessage,
  addPageSuccessMessage
} from '../../../../Redux/Actions';
import config from '../../../../Config';
import { deleteGroup, fetchGroups } from '../../../../Async';
import { convertArrayToObjects } from '../../../../Helper';

class RemoveLink extends React.Component {
  constructor(props) {
    super(props);
    this.click = this.click.bind(this);
  }

  click(event) {
    event.preventDefault();
    event.stopPropagation();
    const {
      groupId,
      updateActiveGroupId,
      updateShowStatusOfCreateGroupForm,
      addPageSuccessMessage,
      addPageErrorMessage,
      triggerLoader,
      updateGroupList
    } = this.props;

    triggerLoader(true);

    // delete group
    deleteGroup(groupId)
      .then(() => {
        triggerLoader(false);
        addPageSuccessMessage('Group is removed successfully');
      })
      .then(() => {
        // collect groups
        fetchGroups().then(groups => {
          // updating group list to the store
          if (groups.length) {
            updateGroupList(convertArrayToObjects(groups));
          } else {
            updateGroupList({});
          }
        });
      })
      .catch(() => {
        triggerLoader(false);
        addPageErrorMessage(
          'Something went wrong while removing this user. Please try later'
        );
      });
    updateShowStatusOfCreateGroupForm(config.page.users.createUserColumn);
    updateActiveGroupId('');
  }

  render() {
    return (
      <a href="#" onClick={this.click}>
        Delete
      </a>
    );
  }
}

RemoveLink.propTypes = {
  groupId: PropTypes.number,
  updateShowStatusOfCreateGroupForm: PropTypes.func.isRequired,
  updateActiveGroupId: PropTypes.func.isRequired,
  addPageSuccessMessage: PropTypes.func.isRequired,
  addPageErrorMessage: PropTypes.func.isRequired,
  triggerLoader: PropTypes.func.isRequired,
  updateGroupList: PropTypes.func.isRequired
};

RemoveLink.defaultProps = {
  groupId: 0
};

const mapDispatchToProps = {
  updateShowStatusOfCreateGroupForm,
  updateActiveGroupId,
  addPageSuccessMessage,
  addPageErrorMessage,
  triggerLoader,
  updateGroupList
};

RemoveLink.displayName = 'RemoveGroupLink';

export default connect(
  null,
  mapDispatchToProps
)(RemoveLink);
