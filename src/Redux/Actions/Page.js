import {
  UPDATE_ACTIVE_USER_IN_USERS_PAGE,
  UPDATE_ACTIVE_RIGHT_COL_USERS_PAGE,
  ADD_ERROR_MESSAGE,
  TURN_OFF_MESSAGE,
  UPDATE_LOADER_STATUS,
  ADD_SUCCESS_MESSAGE,
  UPDATE_SHOW_STATUS_CREATE_GROUP_FORM
} from '../Type';

export function updateActiveUserInUserPage(userId) {
  return {
    type: UPDATE_ACTIVE_USER_IN_USERS_PAGE,
    payload: { userId }
  };
}

export function updateActiveRightColInUserPage(active) {
  return {
    type: UPDATE_ACTIVE_RIGHT_COL_USERS_PAGE,
    payload: { active }
  };
}

export function addPageErrorMessage(message) {
  return {
    type: ADD_ERROR_MESSAGE,
    payload: { message }
  };
}

export function addPageSuccessMessage(message) {
  return {
    type: ADD_SUCCESS_MESSAGE,
    payload: { message }
  };
}

export function turnOffMessage() {
  return {
    type: TURN_OFF_MESSAGE
  };
}

export function triggerLoader(status) {
  return {
    type: UPDATE_LOADER_STATUS,
    payload: { status }
  };
}

export function updateShowStatusOfCreateGroupForm(status) {
  return {
    type: UPDATE_SHOW_STATUS_CREATE_GROUP_FORM,
    payload: { status }
  };
}
