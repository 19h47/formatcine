import './assets/stylesheets/styles.scss';

import Events from './app/modules/events';
import guid from './app/modules/guid';

Events('.js-events');
guid();

console.log('Yo!');
