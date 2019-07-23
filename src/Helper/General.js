export function convertArrayToObjects(arrayToConvert) {
  const newObject = {};
  arrayToConvert.forEach(item => {
    newObject[`item-${item.id}`] = item;
  });

  return newObject;
}

export function convertObjectToArray(objectToConvert) {
  const objectKeys = Object.keys(objectToConvert);

  if (objectKeys.length) {
    return objectKeys.map(objkey => objectToConvert[objkey]) || [];
  }
  return [];
}

export function getRandomFromArray(items) {
  return items[Math.floor(Math.random() * items.length)];
}

export function beautifyObjectResponse(item) {
  const { createdAt, updatedAt, ...rest } = item;

  return {
    ...rest,
    createdAt: createdAt.date,
    updatedAt: updatedAt.date
  };
}

export function beautifyArrayResponse(items) {
  return items.map(beautifyObjectResponse);
}

export function descendingSort(data) {
  return data.sort((a, b) => {
    return b.id - a.id;
  });
}

export function ascendingSort(data) {
  return data.sort((a, b) => {
    return a.id - b.id;
  });
}

export function apiRequestHeader(token) {
  const header = {
    Authorization: `Bearer ${token}`,
    'Content-Type': 'application/json'
  };
  return header;
}
