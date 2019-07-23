import store from '../Redux/Store';

export default function getToken() {
  if (
    store &&
    store.getState() &&
    store.getState().users &&
    store.getState().users.auth
  ) {
    return store.getState().users.auth.token;
  }
  return '';
}
