import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Card from 'react-bootstrap/Card';
import ListGroup from 'react-bootstrap/ListGroup';
import Button from 'react-bootstrap/Button';
import InputGroup from 'react-bootstrap/InputGroup';
import { ascendingSort } from '../../../Helper';
import { assignGroupsToUser, unAssignGroupsFromUser, fetchUserGroups } from '../../../Async';
import {
  triggerLoader,
  addPageSuccessMessage,
  addPageErrorMessage,
  updateActiveUserGroups
} from '../../../Redux/Actions';

class AssignGroups extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      checked: []
    };

    this.onCheck = this.onCheck.bind(this);
    this.save = this.save.bind(this);
  }

  componentDidUpdate(prevProps) {
    const { activeUserGroupIds } = this.props;
    const { activeUserGroupIds: oldGroupIds } = prevProps;

    if (JSON.stringify(activeUserGroupIds) !== JSON.stringify(oldGroupIds)) {
      this.setState({ checked: [...activeUserGroupIds] });
    }
  }

  onCheck(event) {
    const { value, checked } = event.target;
    const { checked: checkedState } = this.state;

    if (checked && !checkedState.includes(Number(value))) {
      this.setState({ checked: [...checkedState, Number(value)] });
    }
    if (!checked && checkedState.includes(Number(value))) {
      this.setState({ checked: checkedState.filter(c => c !== Number(value)) });
    }
  }

  save() {
    const { checked } = this.state;
    const {
      activeUserGroupIds,
      activeUserId,
      triggerLoader,
      addPageErrorMessage,
      addPageSuccessMessage,
      updateActiveUserGroups
    } = this.props;
    const promises = [];
    const groupToAssign = checked.filter(
      gp => !activeUserGroupIds.includes(gp)
    );
    const groupToUnAssign = activeUserGroupIds.filter(
      gp => !checked.includes(gp)
    );

    if (groupToAssign && groupToAssign.length) {
      const promise = assignGroupsToUser(groupToAssign, activeUserId);
      promises.push(promise);
    }
    if (groupToUnAssign && groupToUnAssign.length) {
      const promise = unAssignGroupsFromUser(groupToUnAssign, activeUserId);
      promises.push(promise);
    }

    if (promises.length) {
      triggerLoader(true);
      Promise.all(promises)
        .then(() => {
          triggerLoader(false);
          addPageSuccessMessage('Groups assignments are done successfully');
        })
        .then(() => {
          // collect user groups and update redux store
          fetchUserGroups(activeUserId).then(userGroups => {
            updateActiveUserGroups(userGroups);
          });
        })
        .catch(() => {
          triggerLoader(false);
          addPageErrorMessage(
            'Something went wrong with group assigments. Please try again'
          );
        });
    } else {
      addPageErrorMessage('No changes in the group assigments');
    }
  }

  render() {
    const { checked } = this.state;
    const { groups } = this.props;
    return (
      <Card className="mb-3">
        <Card.Header className="border-bottom">
          <h6 className="m-0">User Groups</h6>
        </Card.Header>
        <Card.Body className="p-0">
          <ListGroup as="ul" variant="flush">
            <ListGroup.Item as="li" className="px-3 pb-2">
              {groups.map(group => (
                <div className="mb-1" key={group.id}>
                  <input
                    id={`box-${group.id}`}
                    type="checkbox"
                    value={group.id}
                    checked={checked.includes(group.id)}
                    onChange={this.onCheck}
                  />
                  <label className="pl-2">{group.name}</label>
                </div>
              ))}
            </ListGroup.Item>
            <ListGroup.Item as="li" className="d-flex px-3">
              <InputGroup className="ml-auto text-center justify-content-center">
                <Button
                  onClick={this.save}
                  type="button"
                  theme="white"
                  className="px-2"
                >
                  <i className="material-icons">assignment_ind</i>
                  Save
                </Button>
              </InputGroup>
            </ListGroup.Item>
          </ListGroup>
        </Card.Body>
      </Card>
    );
  }
}
AssignGroups.propTypes = {
  groups: PropTypes.array.isRequired,
  activeUserGroupIds: PropTypes.array.isRequired
};

const mapStateToProps = ({ groups, page }) => ({
  groups: ascendingSort(Object.values(groups.list) || []),
  activeUserGroupIds: groups.activeUserGroups.map(gp => gp.id) || [],
  activeUserId: Number(page.users.activeUserId.replace('item-', ''))
});

const mapDispatchToProps = {
  addPageErrorMessage,
  addPageSuccessMessage,
  triggerLoader,
  updateActiveUserGroups
};

AssignGroups.displayName = 'AssignGroups';

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(AssignGroups);
