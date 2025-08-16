import './bootstrap';
import jQuery from 'jquery';
import toastr from 'toastr';
import datatable from 'datatable';
import axios from 'axios';
window.$ = jQuery;
window.axios = axios;
window.toastr = toastr
DataTable(window, window.$);