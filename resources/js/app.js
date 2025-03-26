import './bootstrap';
import jQuery from 'jquery';
import toastr from 'toastr';
import datatable from 'datatable';
window.$ = jQuery;
window.toastr = toastr
DataTable(window, window.$);