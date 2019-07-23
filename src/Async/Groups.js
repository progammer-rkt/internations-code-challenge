import axios from 'axios';
import Config from '../Config';
import {
  beautifyArrayResponse,
  beautifyObjectResponse,
  apiRequestHeader,
  getJWt
} from '../Helper';

export function fetchGroups(limit = 10) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'get',
    url: `${Config.service.api.url}api/groups`,
    headers,
    params: {
      limit,
      order: 'desc',
      start: 0
    }
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyArrayResponse(response.data.data);
    }
    return [];
  });
}

export function assigGroup(group, userId) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'post',
    headers,
    url: `${Config.service.api.url}api/group/assign`,
    params: {
      group_id: group,
      user_id: userId
    }
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyArrayResponse(response.data.data);
    }
    return {};
  });
}

export function unAssigGroup(group, userId) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'post',
    url: `${Config.service.api.url}api/group/unassign`,
    headers,
    params: {
      group_id: group,
      user_id: userId
    }
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyArrayResponse(response.data.data);
    }
    return {};
  });
}

export function assignGroupsToUser(groups, userId) {
  const promises = groups.map(group => {
    return assigGroup(group, userId);
  });

  return Promise.all(promises).then(responses => responses);
}

export function unAssignGroupsFromUser(groups, userId) {
  const promises = groups.map(group => {
    return unAssigGroup(group, userId);
  });

  return Promise.all(promises).then(responses => responses);
}

export function updateGroup(groupDetails) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'put',
    url: `${Config.service.api.url}api/group/${groupDetails.id}`,
    headers,
    data: groupDetails
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyObjectResponse(response.data.data);
    }
    return {};
  });
}

export function createGroup(groupDetails) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'post',
    url: `${Config.service.api.url}api/group`,
    headers,
    params: groupDetails
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyObjectResponse(response.data.data);
    }
    return {};
  });
}

export function deleteGroup(groupId) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'delete',
    url: `${Config.service.api.url}api/group/${groupId}`,
    headers
  }).then(response => {
    if (response.data.status === 'success') {
      return true;
    }
    return true;
  });
}
