# User Management application

This is an application which will allow us to create users and groups adn thereby associate groups to users.
This is used to learn Symfony 4 framework

### Highlights

- Symfony 4 is used to develop the API hooks
- React is used to develop the frontend section
- Use JWT autherization to perform all activities.

__________

### API - Details

- Made upon symfony 4.3
- Main entities: user, groups, user-group relations
- User entity has name, country, createdAt, updatedAt attributes
- Group entity has name, createdAt, updatedAt attributes
- User-Group relation entity holds user_id, group_id (indicates the relation to the above enttities) attributes

API endpoints are shown below:

```
 ---------------------------------- -------- -------- ------ ---------------------------
  Name                               Method   Scheme   Host   Path
 ---------------------------------- -------- -------- ------ ---------------------------
  adminAuthenticate                  POST     ANY      ANY    /api/login_check
  createAdminUser                    POST     ANY      ANY    /api/create/admin
  getGroupList                       GET      ANY      ANY    /api/groups
  createGroup                        POST     ANY      ANY    /api/group
  deleteGroupDetails                 DELETE   ANY      ANY    /api/group/{groupId}
  getGroupDetails                    GET      ANY      ANY    /api/group/{groupId}
  updateGroup                        PUT      ANY      ANY    /api/group/{groupId}
  assignGroupToUser                  POST     ANY      ANY    /api/group/assign
  getUserGroups                      GET      ANY      ANY    /api/user/groups/{userId}
  getUserList                        GET      ANY      ANY    /api/users
  createUser                         POST     ANY      ANY    /api/user
  deleteUserDetails                  DELETE   ANY      ANY    /api/user/{userId}
  getUserDetails                     GET      ANY      ANY    /api/user/{userId}
  unAssignGroupToUser                POST     ANY      ANY    /api/group/unassign
  updateUser                         PUT      ANY      ANY    /api/user/{userId}
 ---------------------------------- -------- -------- ------ ---------------------------
```
As we can see above there are 14 API hooks available. Details of each service given below:

##### Admin User Related

- **adminAuthenticate**: Use to authenticate an admin user. This will provide a JWT in response
-  **createAdminUser**: Create an admin user.

##### Group Related

- **getGroupList**: Provide a collection of groups. We can filter this collection by `limit`, `order` and `start`
- **createGroup**: Creates a group
- **deleteGroupDetails**: Deletes a group. When a group is deleted, the user-group relations corresponds to that group also will be removed
- **updateGroup**: Updates a group's details
- **getGroupDetails** - Provide details of a specified group

##### User Related

- **getUserList**: Provide list of users. We can filter the results by `limit`, `order` and `start`.
- **createUser**: Creates a user
- **updateUser**: Update details of a specified user
- **deleteUserDetails**: Deletes a user. When a user is deleted, the user-group relations corresponds to that user will be removed.
- **getUserDetails**: Provides details of a specified user.

##### User-Group Relations Related

- **assignGroupToUser**: Assign a group to a specified user.
- **unAssignGroupToUser**: UnAssign a group from a user.
- **getUserGroups**: This will provide groups list which are associated with a specified user.

### Frontend - Details

- Frontend is developed by React App.
- Used a bootstrap template in order to get a cool look

### How to install

- API is available in `backend` branch
- Front app is available in `frontend` branch
- Please refer install details in the corresponding branch

Bye...
