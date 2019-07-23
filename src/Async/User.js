import axios from 'axios';
import Config from '../Config';
import {
  beautifyArrayResponse,
  beautifyObjectResponse,
  getJWt,
  apiRequestHeader
} from '../Helper';

export function fetchUsers(limit = 100) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'get',
    url: `${Config.service.api.url}api/users`,
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

export function createUserRequest(userDetials) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'post',
    url: `${Config.service.api.url}api/user`,
    headers,
    params: userDetials
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyObjectResponse(response.data.data);
    }
    return {};
  });
}

export function updateUserDetailsRequest(userDetials) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'put',
    url: `${Config.service.api.url}api/user/${userDetials.id}`,
    headers,
    data: userDetials
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyObjectResponse(response.data.data);
    }
    return {};
  });
}

export function fetchUserGroups(userId) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'get',
    url: `${Config.service.api.url}api/user/groups/${userId}`,
    headers
  }).then(response => {
    if (response.data.status === 'success') {
      return beautifyArrayResponse(response.data.data);
    }
    return [];
  });
}

export function deleteUser(userId) {
  const headers = apiRequestHeader(getJWt());
  return axios({
    method: 'delete',
    url: `${Config.service.api.url}api/user/${userId}`,
    headers
  }).then(response => {
    if (response.data.status === 'success') {
      return true;
    }
    return true;
  });
}
