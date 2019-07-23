import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';
import ListGroup from 'react-bootstrap/ListGroup';
import ListGroupItem from 'react-bootstrap/ListGroupItem';
import FigureImage from 'react-bootstrap/FigureImage';

import userAvatar0 from '../../../images/avatars/0.jpg';
import userAvatar1 from '../../../images/avatars/1.jpg';
import userAvatar2 from '../../../images/avatars/2.jpg';
import userAvatar3 from '../../../images/avatars/3.jpg';
import { getRandomFromArray, convertArrayToObjects } from '../../../Helper';
import { deleteUser, fetchUsers } from '../../../Async';
import {
  triggerLoader,
  addPageSuccessMessage,
  addPageErrorMessage,
  updateUserList,
  updateActiveUserInUserPage
} from '../../../Redux/Actions';

const avatarImgs = [userAvatar0, userAvatar1, userAvatar2, userAvatar3];

class Profile extends React.Component {
  constructor(props) {
    super(props);
    this.removeUser = this.removeUser.bind(this);
  }

  removeUser() {
    const {
      user,
      triggerLoader,
      addPageErrorMessage,
      addPageSuccessMessage,
      updateUserList,
      updateActiveUserInUserPage,
    } = this.props;
    const { id: userId } = user;

    triggerLoader(true);
    deleteUser(userId)
      .then(() => {
        triggerLoader(false);
        addPageSuccessMessage('User is removed successfully');
      })
      .then(() => {
        // collect users list
        fetchUsers()
          .then(users => {
            // updating user list to the store
            if (users.length) {
              const usersObj = convertArrayToObjects(users);
              updateUserList(usersObj);
              return usersObj;
            }
            return {};
          })
          .then(users => {
            // make first user in the list as the active user
            if (Object.keys(users).length > 0) {
              updateActiveUserInUserPage(Object.keys(users)[0]);
            }
          });
      })
      .catch(() => {
        triggerLoader(false);
        addPageErrorMessage('User could not removed. Please try again');
      });
  }

  render() {
    const { user, groups } = this.props;
    return (
      <Card className="mb-4">
        <Card.Header className="border-bottom text-center">
          <div className="mb-3 mx-auto">
            <FigureImage
              roundedCircle
              src={getRandomFromArray(avatarImgs)}
              alt={user.fullname}
              width="110"
            />
          </div>
          <h4 className="mb-0">{user.fullname}</h4>
          <span className="text-muted d-block mb-2">{user.country}</span>
          <Button
            type="button"
            variant="danger"
            size="sm"
            className="mb-2"
            onClick={this.removeUser}
          >
            <i className="material-icons mr-1">close</i>
            Remove
          </Button>
        </Card.Header>
        <ListGroup>
          <ListGroupItem className="p-4">
            <strong className="text-muted d-block mb-2">Groups Assigned</strong>
            <div>
              {groups.map(tag => (
                <Button
                  key={tag.id}
                  variant="outline-dark"
                  className="mr-1 mb-1"
                >
                  {tag.name}
                </Button>
              ))}
              <p>{!groups.length ? 'No groups assigned...' : ''}</p>
            </div>
          </ListGroupItem>
        </ListGroup>
      </Card>
    );
  }
}

Profile.propTypes = {
  user: PropTypes.object.isRequired,
  groups: PropTypes.array
};

Profile.defaultProps = {
  groups: []
};

const mapStateToProps = ({ users, page, groups }) => ({
  user: users.list[page.users.activeUserId] || {},
  groups: groups.activeUserGroups
});

const mapDispatchToProps = {
  triggerLoader,
  addPageErrorMessage,
  addPageSuccessMessage,
  updateActiveUserInUserPage,
  updateUserList
};

Profile.displayName = 'UserProfile';

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Profile);
