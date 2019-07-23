import {
  UPDATE_GROUP_LIST,
  UPDATE_ACTIVE_USER_GROUPS,
  UPDATE_ACTIVE_GROUP,
  ADD_NEW_GROUP,
  UPDATE_GROUP_DETAILS
} from '../Type';

const initialState = {
  activeUserGroups: [],
  activeGroupId: '',
  list: {}
};

function GroupReducer(state = initialState, action) {
  const { type, payload } = action;

  if (type === UPDATE_GROUP_LIST) {
    return {
      ...state,
      list: { ...payload.groups }
    };
  }

  if (type === UPDATE_ACTIVE_USER_GROUPS) {
    return {
      ...state,
      activeUserGroups: payload.groups
    };
  }

  if (type === UPDATE_ACTIVE_GROUP) {
    return {
      ...state,
      activeGroupId: payload.groupId
    };
  }

  if (type === ADD_NEW_GROUP || type === UPDATE_GROUP_DETAILS) {
    return {
      ...state,
      list: {
        ...state.list,
        [`item-${payload.group.id}`]: {
          ...payload.group
        }
      }
    };
  }

  return state;
}

export default GroupReducer;
