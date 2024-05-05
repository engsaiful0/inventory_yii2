//Just Run These Query At Once:
//=============================
// configuration tables:
//=========================
delete from customers;
delete from customer_contact_persons;
delete from suppliers;
delete from supplier_contact_persons;
delete from employees;
delete from departments;
delete from designations;
delete from banks;
delete from mfis;
delete from stores;
delete from grades;
delete from machines;
delete from machine_names;
delete from p_brand;
delete from p_model;
delete from user_store;
delete from selling_price;
delete from costing_price;
delete from cats;
delete from cats_sub;
delete from items;


// transaction tables:
//======================
delete from inventory;
delete from stock_transfer_history;
delete from store_inventory;
delete from storck_tranfer_history_from_temp_to_main;
delete from store_requisition;
delete from store_req_d_r;
delete from purchase_requisition;
delete from purchase_procurement;
delete from purchase_order;
delete from purchase_rcv_rtn;
delete from supplier_mr;
delete from master_lc;
delete from import_document;
delete from sale_order;
delete from sell_delv_rtn;
delete from customer_bill;
delete from customer_mr;
delete from credit_memo;
delete from pos;
delete from production_input;
delete from production_output;
delete from production_wastage;
delete from members;
delete from member_points;
delete from member_points_conf;
