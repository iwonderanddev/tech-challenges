import { createServer } from 'miragejs';

createServer({
  logging: true,
  routes() {
    this.get('/api/surveys', () => {
      return [
        {
          'id': 1,
          'name': 'Paris',
        },
        {
          'id': 2,
          'name': 'Timișoara',
        },
        {
          'name': 'New York',
          'id': 3,
        },
      ];
    });
    this.get('/api/survey/1', () => {
      return [
        {
          'label': 'Number of products?',
          'type': 'numeric',
          'answers': [5200, 540, 670, 470, 400, 1400, 400, 1200],
        },
        {
          'answers': [
            '2017-06-09T10:10:00.000Z',
            '2020-04-29T11:00:00.000Z',
            '2017-09-14T09:55:00.000Z',
            '2016-03-29T15:30:00.000Z',
            '2019-02-28T15:30:00.000Z',
          ],
          'type': 'date',
          'label': 'What is the visit date?',
        },
        {
          'type': 'mcq',
          'label': 'What best sellers are available in your store?',
          'options': ['Product 1', 'Product 2', 'Product 3', 'Product 4', 'Product 5', 'Product 6'],
          'answers': [
            [true, false, true, true, true, true],
            [true, false, true, false, true, false],
            [false, false, true, true, true, true],
            [true, false, true, true, false, false],
            [false, false, true, false, false, false],
            [true, false, true, false, true, false]
          ],
        },
      ];
    });
    this.get('/api/survey/2', () => {
      return [
        {
          'type': 'numeric',
          'label': 'Number of products?',
          'answers': [1200, 2300, 768, 98, 502],
        },
        {
          'label': 'What is the visit date?',
          'type': 'date',
          'answers': [
            '2016-08-28T08:00:00.000Z',
            '2019-10-25T12:50:00.000Z',
            '2017-08-26T16:50:00.000Z',
            '2020-09-25T17:10:00.000Z',
            '2017-08-25T09:30:00.000Z',
            '2021-07-25T19:01:00.000Z',
          ],
        },
        {
          'type': 'mcq',
          'label': 'What best sellers are available in your store?',
          'options': ['Product 1', 'Product 2', 'Product 3', 'Product 4', 'Product 5', 'Product 6'],
          'answers': [
            [false, true, true, false, true, false],
            [true, true, true, true, true, true],
            [true, true, true, true, true, false],
            [true, false, true, true, true, true],
            [false, false, true, false, true, false],
          ],
        },
      ];
    });
    this.get('/api/survey/3', () => {
      return [
        {
          'label': 'Number of products?',
          'type': 'numeric',
          'answers': [42, 2201, 447, 19, 756, 143, 280, 97, 127],
        },
        {
          'label': 'What is the visit date?',
          'type': 'date',
          'answers': [
            '2021-09-25T12:00:00.000Z',
            '2018-08-25T14:25:00.000Z',
            '2017-10-25T08:25:00.000Z',
            '2022-06-25T18:55:00.000Z'
          ],
        },
        {
          'type': 'mcq',
          'label': 'What best sellers are available in your store?',
          'options': ['Product 1', 'Product 2', 'Product 3', 'Product 5', 'Product 4', 'Product 6'],
          'answers': [
            [false, true, true, false, true, false],
            [true, true, true, true, true, true],
            [false, true, true, true, true, true],
            [true, true, true, true, true, true],
            [false, false, true, false, true, false],
          ],
        },
      ];
    });
  },
});
