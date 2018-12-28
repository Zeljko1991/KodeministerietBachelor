
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuetify = require('vuetify');
window.swal = require('sweetalert2');
window.Vuelidate = require('vuelidate');

Vue.use(Vuetify);
Vue.use(Vuelidate);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('kanban-board', require('./components/KanbanBoard.vue'));
Vue.component('dashboard-wrap', require('./components/DashboardWrap.vue'));
Vue.component('case-statistics', require('./components/CaseStatistics.vue'));
Vue.component('site-nav', require('./components/Layout/SiteNavigation.vue'));
Vue.component('customer-view', require('./components/Customers/Customers.vue'));
Vue.component('projectcase-view', require('./components/ProjectCases/ProjectCases.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: () => ({
        drawer: null
      }),
});


//Materialize Element Initialization
// $(document).ready(function(){
//     //Jquery Inits
//     $('.collapsible').collapsible();
//     $('.modal').modal();
//     $('input#input_text, input#EAN').characterCounter();
//     $('input#input_text, input#CVR').characterCounter();
//     $(".dropdown-trigger").dropdown({
//         coverTrigger: false,
//     });
//     $('select:not(.swal2-select)').formSelect();
//     $('.fak').on('click', (event) => {
//         event.preventDefault();
//         return swal({
//                 title: "Are you sure you want to delete this subcase?",
//                 text: "There won't be any going back!",
//                 type: "warning",
//                 showCancelButton: true,
//             }).then((result) => {
//                     if(result.value) {
//                         document.getElementById(event.target.id).closest('form').submit();
//                     }
//                 });
//     });
//     $(document).ready(function(){
//         $('select').formSelect();
//       });




//     //Adding fields
//         var postURL = "<?php echo url('addmore'); ?>";
//         var i=1;


//         $('#add').click(function(){
//             event.preventDefault();
//              i++;
//              $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="deliverable[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn red btn_remove">X</button></td></tr>');
//         });

//         $('#addDeliv').click(function(){
//             event.preventDefault();
//             i++;
//              $('#dynamic_field_edit').append('<tr id="delivrow'+i+'" class="dynamic-added"><td><input type="text" name="deliverable[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn red btn_remove_added">X</button></td></tr>');
//         });

//         $(document).on('click', '.btn_remove_added', function(){
//             var button_id = $(this).attr("id");
//             $('#delivrow'+button_id+'').remove();
//         });

//         $(document).on('click', '.btn_remove_deliv', function(){
//             var button_id = $(this).attr("id");
//             $(this).closest('#delivrowD'+button_id+'').find('input').val('');
//             $('#delivrowD'+button_id+'').attr('hidden', true);
//         });

//         $(document).on('click', '.btn_remove', function(){
//              var button_id = $(this).attr("id");
//              $('#row'+button_id+'').remove();
//         });
// });
