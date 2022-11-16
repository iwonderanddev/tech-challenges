import { createServer } from 'miragejs';

createServer({
  logging: true,
  routes() {
    this.get('/api/surveys', () => {
      return [
        {
          'name': 'Melun',
          'code': 'XX3',
        },
        {
          'code': 'XX2',
          'name': 'Chartres',
        },
        {
          'name': 'Paris',
          'code': 'XX1',
        },
      ];
    });
    this.get('/api/survey/XX1', () => {
      return [
        {
          'type': 'qcm',
          'label': 'What best sellers are available in your store?',
          'result': {
            'Product 2': 2,
            'Product 3': 1,
            'Product 4': 0,
            'Product 1': 0,
            'Product 5': 4,
            'Product 6': 0,
          },
        },
        {
          'label': 'Number of products?',
          'type': 'numeric',
          'result': 697.2,
        },
        {
          'result': [
            '2017-06-09T00:00:00.000Z',
            '2016-04-29T11:04:50.000Z',
            '2017-09-14T09:45:00.000Z',
            '2016-03-29T11:04:50.000Z',
            '2016-02-28T11:04:50.000Z',
          ],
          'type': 'date',
          'label': 'What is the visit date?',
        },
      ];
    });
    this.get('/api/survey/XX2', () => {
      return [
        {
          'result': {
            'Product 2': 4,
            'Product 5': 6,
            'Product 3': 6,
            'Product 1': 4,
            'Product 4': 3,
            'Product 6': 3,
          },
          'type': 'qcm',
          'label': 'What best sellers are available in your store?',
        },
        {
          'result': 4733.33333333333,
          'type': 'numeric',
          'label': 'Number of products?',
        },
        {
          'label': 'What is the visit date?',
          'type': 'date',
          'result': [
            '2016-08-28T12:04:50.000Z',
            '2017-10-25T12:04:50.000Z',
            '2017-08-26T12:04:50.000Z',
            '2017-09-25T12:04:50.000Z',
            '2017-08-25T12:04:50.000Z',
            '2017-07-25T12:04:50.000Z',
          ],
        },
      ];
    });
    this.get('/api/survey/XX3', () => {
      return [
        {
          'result': {
            'Product 5': 4,
            'Product 4': 4,
            'Product 3': 4,
            'Product 1': 4,
            'Product 6': 3,
            'Product 2': 2,
          },
          'type': 'qcm',
          'label': 'What best sellers are available in your store?',
        },
        {
          'label': 'Number of products?',
          'result': 6200,
          'type': 'numeric'
        },
        {
          'label': 'What is the visit date?',
          'type': 'date',
          'result': [
            '2017-09-25T12:04:50.000Z',
            '2017-08-25T12:04:50.000Z',
            '2017-10-25T12:04:50.000Z',
            '2017-06-25T12:04:50.000Z'
          ],
        },
      ];
    });
  },
});
