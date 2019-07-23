import {
  UPDATE_ACTIVE_USER,
  UPDATE_USER_LIST,
  ADD_NEW_USER,
  UPDATE_USER_DETAILS,
  UPDATE_AUTH_TOKEN
} from '../Type';

export function updateUserList(users) {
  return {
    type: UPDATE_USER_LIST,
    payload: { users }
  };
}

export function updateActiveUser(userId) {
  return {
    type: UPDATE_ACTIVE_USER,
    payload: { userId }
  };
}

export function addNewUserToList(user) {
  return {
    type: ADD_NEW_USER,
    payload: { user }
  };
}

export function updateUserDetailsList(user) {
  return {
    type: UPDATE_USER_DETAILS,
    payload: { user }
  };
}

export function updateUserToken(token) {
  return {
    type: UPDATE_AUTH_TOKEN,
    payload: { token }
  };
}
