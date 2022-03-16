
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import ChatConversations from './components/ChatConversations';
import ChatMessages from './components/ChatMessages';
import ChatForm from './components/ChatForm';
import ConversationParticipants from './components/ConversationParticipants';




Vue.component('chat-conversations', ChatConversations);
Vue.component('chat-messages', ChatMessages);
Vue.component('chat-form', ChatForm);
Vue.component('conversation-participants', ConversationParticipants);




const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

const app = new Vue({
    el: '#app'
});
