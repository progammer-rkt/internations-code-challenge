import {
  UPDATE_USER_LIST,
  ADD_NEW_USER,
  UPDATE_USER_DETAILS,
  UPDATE_AUTH_TOKEN
} from '../Type';

const initialState = {
  list: {},
  auth: {
    token: ''
  }
};

function UserReducer(state = initialState, action) {
  const { type, payload } = action;

  if (type === UPDATE_USER_LIST) {
    return {
      ...state,
      list: { ...payload.users }
    };
  }

  if (type === ADD_NEW_USER || type === UPDATE_USER_DETAILS) {
    return {
      ...state,
      list: {
        ...state.list,
        [`item-${payload.user.id}`]: {
          ...payload.user
        }
      }
    };
  }

  if (type === UPDATE_AUTH_TOKEN) {
    return {
      ...state,
      auth: {
        token: payload.token
      }
    };
  }
  return state;
}

export default UserReducer;
