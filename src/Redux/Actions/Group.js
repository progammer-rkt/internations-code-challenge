import {
  UPDATE_GROUP_LIST,
  UPDATE_ACTIVE_USER_GROUPS,
  UPDATE_ACTIVE_GROUP,
  ADD_NEW_GROUP,
  UPDATE_GROUP_DETAILS
} from '../Type';

export function updateGroupList(groups) {
  return {
    type: UPDATE_GROUP_LIST,
    payload: { groups }
  };
}

export function updateActiveUserGroups(groups) {
  return {
    type: UPDATE_ACTIVE_USER_GROUPS,
    payload: { groups }
  };
}

export function updateActiveGroupId(groupId) {
  return {
    type: UPDATE_ACTIVE_GROUP,
    payload: { groupId }
  };
}

export function addNewGroupToList(group) {
  return {
    type: ADD_NEW_GROUP,
    payload: { group }
  };
}

export function updateGroupDetailsInList(group) {
  return {
    type: UPDATE_GROUP_DETAILS,
    payload: { group }
  };
}
