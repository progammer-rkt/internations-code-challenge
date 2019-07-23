import {
  UPDATE_ACTIVE_USER_IN_USERS_PAGE,
  UPDATE_ACTIVE_RIGHT_COL_USERS_PAGE,
  ADD_ERROR_MESSAGE,
  ADD_SUCCESS_MESSAGE,
  TURN_OFF_MESSAGE,
  UPDATE_LOADER_STATUS,
  UPDATE_SHOW_STATUS_CREATE_GROUP_FORM
} from '../Type';
import Config from '../../Config';

const initialState = {
  hasMessageAdded: false,
  loader: false,
  message: {},
  users: {
    activeRightCol: Config.page.users.profileColumn,
    activeUserId: ''
  },
  groups: {
    showGroupForm: false
  }
};

function PageReducer(state = initialState, action) {
  const { type, payload } = action;

  if (type === UPDATE_ACTIVE_USER_IN_USERS_PAGE) {
    return {
      ...state,
      users: {
        ...state.users,
        activeUserId: payload.userId
      }
    };
  }
  if (type === UPDATE_ACTIVE_RIGHT_COL_USERS_PAGE) {
    return {
      ...state,
      users: {
        ...state.users,
        activeRightCol: payload.active
      }
    };
  }

  if (type === ADD_ERROR_MESSAGE) {
    return {
      ...state,
      hasMessageAdded: true,
      message: {
        type: Config.message.type.error,
        value: payload.message
      }
    };
  }

  if (type === ADD_SUCCESS_MESSAGE) {
    return {
      ...state,
      hasMessageAdded: true,
      message: {
        type: Config.message.type.success,
        value: payload.message
      }
    };
  }

  if (type === TURN_OFF_MESSAGE) {
    return {
      ...state,
      hasMessageAdded: false,
      message: {}
    };
  }

  if (type === UPDATE_LOADER_STATUS) {
    return {
      ...state,
      loader: payload.status
    };
  }

  if (type === UPDATE_SHOW_STATUS_CREATE_GROUP_FORM) {
    return {
      ...state,
      groups: {
        ...state.groups,
        showGroupForm: payload.status
      }
    };
  }

  return state;
}

export default PageReducer;
