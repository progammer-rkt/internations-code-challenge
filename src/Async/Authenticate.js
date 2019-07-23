import axios from 'axios';
import Config from '../Config';

export default function authenticateUser(credentials) {
  return axios({
    method: 'post',
    url: `${Config.service.api.url}api/login_check`,
    params: credentials
  }).then(response => {
    if (response.data.status === 'success') {
      return response.data.data;
    }
    return {};
  });
}
