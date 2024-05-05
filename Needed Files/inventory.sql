/*
SQLyog Enterprise - MySQL GUI v7.1 
MySQL - 5.5.34 : Database - inventory
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `AuthAssignment` */

DROP TABLE IF EXISTS `AuthAssignment`;

CREATE TABLE `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `AuthAssignment` */

insert  into `AuthAssignment`(`itemname`,`userid`,`bizrule`,`data`) values ('POS User','2',NULL,'N;'),('SuperAdmin','1',NULL,'N;');

/*Table structure for table `AuthItem` */

DROP TABLE IF EXISTS `AuthItem`;

CREATE TABLE `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `AuthItem` */

insert  into `AuthItem`(`name`,`type`,`description`,`bizrule`,`data`) values ('Banks.*',1,NULL,NULL,'N;'),('Banks.Admin',0,NULL,NULL,'N;'),('Banks.Create',0,NULL,NULL,'N;'),('Banks.CreateBankFromOutSide',0,NULL,NULL,'N;'),('Banks.Delete',0,NULL,NULL,'N;'),('Banks.Update',0,NULL,NULL,'N;'),('Cats.*',1,NULL,NULL,'N;'),('Cats.Admin',0,NULL,NULL,'N;'),('Cats.Create',0,NULL,NULL,'N;'),('Cats.CreateCatFromOutSide',0,NULL,NULL,'N;'),('Cats.Delete',0,NULL,NULL,'N;'),('Cats.Update',0,NULL,NULL,'N;'),('CatsSub.*',1,NULL,NULL,'N;'),('CatsSub.Admin',0,NULL,NULL,'N;'),('CatsSub.Create',0,NULL,NULL,'N;'),('CatsSub.CreateCatSubFromOutSide',0,NULL,NULL,'N;'),('CatsSub.Delete',0,NULL,NULL,'N;'),('CatsSub.Update',0,NULL,NULL,'N;'),('CostingPrice.*',1,NULL,NULL,'N;'),('CostingPrice.AddCostingPrice',0,NULL,NULL,'N;'),('CostingPrice.Admin',0,NULL,NULL,'N;'),('CostingPrice.Delete',0,NULL,NULL,'N;'),('CostingPrice.PriceHistory',0,NULL,NULL,'N;'),('CostingPrice.Update',0,NULL,NULL,'N;'),('Countries.*',1,NULL,NULL,'N;'),('Countries.Admin',0,NULL,NULL,'N;'),('Countries.Create',0,NULL,NULL,'N;'),('Countries.CreateCountryFromOutSide',0,NULL,NULL,'N;'),('Countries.Delete',0,NULL,NULL,'N;'),('Countries.Update',0,NULL,NULL,'N;'),('CreditMemo.*',1,NULL,NULL,'N;'),('CreditMemo.Admin',0,NULL,NULL,'N;'),('CreditMemo.Create',0,NULL,NULL,'N;'),('CreditMemo.Delete',0,NULL,NULL,'N;'),('CreditMemo.DeleteAll',0,NULL,NULL,'N;'),('CreditMemo.Update',0,NULL,NULL,'N;'),('CreditMemo.VoucherPreview',0,NULL,NULL,'N;'),('CustomerBill.*',1,NULL,NULL,'N;'),('CustomerBill.Admin',0,NULL,NULL,'N;'),('CustomerBill.AdminCreditMemo',0,NULL,NULL,'N;'),('CustomerBill.BillCreate',0,NULL,NULL,'N;'),('CustomerBill.BillCreateView',0,NULL,NULL,'N;'),('CustomerBill.BillPreview',0,NULL,NULL,'N;'),('CustomerBill.Create',0,NULL,NULL,'N;'),('CustomerBill.Delete',0,NULL,NULL,'N;'),('CustomerBill.DeleteAll',0,NULL,NULL,'N;'),('CustomerContactPersons.*',1,NULL,NULL,'N;'),('CustomerContactPersons.AddContactPerson',0,NULL,NULL,'N;'),('CustomerContactPersons.Admin',0,NULL,NULL,'N;'),('CustomerContactPersons.ContactPersonsOfThis',0,NULL,NULL,'N;'),('CustomerContactPersons.Contacts',0,NULL,NULL,'N;'),('CustomerContactPersons.Create',0,NULL,NULL,'N;'),('CustomerContactPersons.Delete',0,NULL,NULL,'N;'),('CustomerContactPersons.Update',0,NULL,NULL,'N;'),('CustomerMr.*',1,NULL,NULL,'N;'),('CustomerMr.AddMoneyReceipt',0,NULL,NULL,'N;'),('CustomerMr.Admin',0,NULL,NULL,'N;'),('CustomerMr.Delete',0,NULL,NULL,'N;'),('CustomerMr.DeleteAll',0,NULL,NULL,'N;'),('CustomerMr.MoneyReceiptHistory',0,NULL,NULL,'N;'),('CustomerMr.MrPreview',0,NULL,NULL,'N;'),('CustomerMr.Update',0,NULL,NULL,'N;'),('Customers.*',1,NULL,NULL,'N;'),('Customers.Admin',0,NULL,NULL,'N;'),('Customers.AdminMoneyReceipt',0,NULL,NULL,'N;'),('Customers.Create',0,NULL,NULL,'N;'),('Customers.CreateCustomerFromOutSide',0,NULL,NULL,'N;'),('Customers.CustomerLedgerAll',0,NULL,NULL,'N;'),('Customers.CustomerLedgerAllView',0,NULL,NULL,'N;'),('Customers.CustomerLedgerSpecific',0,NULL,NULL,'N;'),('Customers.CustomerLedgerSpecificView',0,NULL,NULL,'N;'),('Customers.Delete',0,NULL,NULL,'N;'),('Customers.Update',0,NULL,NULL,'N;'),('Customers.View',0,NULL,NULL,'N;'),('DashBoardReport.*',1,NULL,NULL,'N;'),('DashBoardReport.LiabilitiesGraphPreview',0,NULL,NULL,'N;'),('DashBoardReport.LiabilitiesPreview',0,NULL,NULL,'N;'),('DashBoardReport.PurchasePreview',0,NULL,NULL,'N;'),('DashBoardReport.SalesPreview',0,NULL,NULL,'N;'),('Departments.*',1,NULL,NULL,'N;'),('Departments.Admin',0,NULL,NULL,'N;'),('Departments.Create',0,NULL,NULL,'N;'),('Departments.CreateDepartmentFromOutSide',0,NULL,NULL,'N;'),('Departments.Delete',0,NULL,NULL,'N;'),('Departments.Update',0,NULL,NULL,'N;'),('Designations.*',1,NULL,NULL,'N;'),('Designations.Admin',0,NULL,NULL,'N;'),('Designations.Create',0,NULL,NULL,'N;'),('Designations.CreateMain',0,NULL,NULL,'N;'),('Designations.Delete',0,NULL,NULL,'N;'),('Designations.Update',0,NULL,NULL,'N;'),('Employees.*',1,NULL,NULL,'N;'),('Employees.Admin',0,NULL,NULL,'N;'),('Employees.Create',0,NULL,NULL,'N;'),('Employees.CreateEmployeeFromOutSide',0,NULL,NULL,'N;'),('Employees.Delete',0,NULL,NULL,'N;'),('Employees.Update',0,NULL,NULL,'N;'),('Employees.View',0,NULL,NULL,'N;'),('Grades.*',1,NULL,NULL,'N;'),('Grades.Admin',0,NULL,NULL,'N;'),('Grades.Create',0,NULL,NULL,'N;'),('Grades.CreateGradesFromOutSide',0,NULL,NULL,'N;'),('Grades.Delete',0,NULL,NULL,'N;'),('Grades.Update',0,NULL,NULL,'N;'),('ImportDocument.*',1,NULL,NULL,'N;'),('ImportDocument.Admin',0,NULL,NULL,'N;'),('ImportDocument.Create',0,NULL,NULL,'N;'),('ImportDocument.Delete',0,NULL,NULL,'N;'),('ImportDocument.Update',0,NULL,NULL,'N;'),('ImportDocument.View',0,NULL,NULL,'N;'),('Inventory.*',1,NULL,NULL,'N;'),('Inventory.Admin',0,NULL,NULL,'N;'),('Inventory.Create',0,NULL,NULL,'N;'),('Inventory.Delete',0,NULL,NULL,'N;'),('Inventory.DeleteAll',0,NULL,NULL,'N;'),('Inventory.StockReport',0,NULL,NULL,'N;'),('Inventory.StockReportView',0,NULL,NULL,'N;'),('Inventory.TransferStock',0,NULL,NULL,'N;'),('Inventory.TransferStockCreate',0,NULL,NULL,'N;'),('Inventory.TransferStockView',0,NULL,NULL,'N;'),('Inventory.Update',0,NULL,NULL,'N;'),('Items.*',1,NULL,NULL,'N;'),('Items.Admin',0,NULL,NULL,'N;'),('Items.AdminAddCostingPrice',0,NULL,NULL,'N;'),('Items.AdminAddSellingPrice',0,NULL,NULL,'N;'),('Items.BarCodeGen',0,NULL,NULL,'N;'),('Items.Create',0,NULL,NULL,'N;'),('Items.CreateItemFromOutSide',0,NULL,NULL,'N;'),('Items.Delete',0,NULL,NULL,'N;'),('Items.DeleteAll',0,NULL,NULL,'N;'),('Items.ItemsOfThis',0,NULL,NULL,'N;'),('Items.ItemsOfThisCat',0,NULL,NULL,'N;'),('Items.ItemsOfThisSupplier',0,NULL,NULL,'N;'),('Items.SetAsRawMat',0,NULL,NULL,'N;'),('Items.SetUnitConvertable',0,NULL,NULL,'N;'),('Items.SetVatable',0,NULL,NULL,'N;'),('Items.UndoAsRawMat',0,NULL,NULL,'N;'),('Items.UndoUnitConvertable',0,NULL,NULL,'N;'),('Items.UndoVatable',0,NULL,NULL,'N;'),('Items.Update',0,NULL,NULL,'N;'),('MachineNames.*',1,NULL,NULL,'N;'),('MachineNames.Admin',0,NULL,NULL,'N;'),('MachineNames.Create',0,NULL,NULL,'N;'),('MachineNames.Delete',0,NULL,NULL,'N;'),('MachineNames.Update',0,NULL,NULL,'N;'),('Machines.*',1,NULL,NULL,'N;'),('Machines.Admin',0,NULL,NULL,'N;'),('Machines.Create',0,NULL,NULL,'N;'),('Machines.Delete',0,NULL,NULL,'N;'),('Machines.Update',0,NULL,NULL,'N;'),('MasterLc.*',1,NULL,NULL,'N;'),('MasterLc.Admin',0,NULL,NULL,'N;'),('MasterLc.Create',0,NULL,NULL,'N;'),('MasterLc.Delete',0,NULL,NULL,'N;'),('MasterLc.DetailsOfThisLc',0,NULL,NULL,'N;'),('MasterLc.Update',0,NULL,NULL,'N;'),('MasterLc.VerifiedImportPurchaseOrder',0,NULL,NULL,'N;'),('MasterLc.View',0,NULL,NULL,'N;'),('MemberPointsConf.*',1,NULL,NULL,'N;'),('MemberPointsConf.Admin',0,NULL,NULL,'N;'),('MemberPointsConf.Create',0,NULL,NULL,'N;'),('MemberPointsConf.Delete',0,NULL,NULL,'N;'),('MemberPointsConf.Update',0,NULL,NULL,'N;'),('Members.*',1,NULL,NULL,'N;'),('Members.AddPoints',0,NULL,NULL,'N;'),('Members.Admin',0,NULL,NULL,'N;'),('Members.AvailablePointsOfThis',0,NULL,NULL,'N;'),('Members.Create',0,NULL,NULL,'N;'),('Members.CreateMembersFromOutSide',0,NULL,NULL,'N;'),('Members.Delete',0,NULL,NULL,'N;'),('Members.MembersAVpoint',0,NULL,NULL,'N;'),('Members.PointsHistory',0,NULL,NULL,'N;'),('Members.ReducePoints',0,NULL,NULL,'N;'),('Members.Update',0,NULL,NULL,'N;'),('Mfis.*',1,NULL,NULL,'N;'),('Mfis.Admin',0,NULL,NULL,'N;'),('Mfis.Create',0,NULL,NULL,'N;'),('Mfis.CreateMfisFromOutSide',0,NULL,NULL,'N;'),('Mfis.Delete',0,NULL,NULL,'N;'),('Mfis.Update',0,NULL,NULL,'N;'),('PBrand.*',1,NULL,NULL,'N;'),('PBrand.Admin',0,NULL,NULL,'N;'),('PBrand.Create',0,NULL,NULL,'N;'),('PBrand.CreatePBrandFromOutSide',0,NULL,NULL,'N;'),('PBrand.Delete',0,NULL,NULL,'N;'),('PBrand.Update',0,NULL,NULL,'N;'),('PModel.*',1,NULL,NULL,'N;'),('PModel.Admin',0,NULL,NULL,'N;'),('PModel.Create',0,NULL,NULL,'N;'),('PModel.CreatePModelFromOutSide',0,NULL,NULL,'N;'),('PModel.Delete',0,NULL,NULL,'N;'),('PModel.Update',0,NULL,NULL,'N;'),('POS User',2,'POS User',NULL,'N;'),('Pos.*',1,NULL,NULL,'N;'),('Pos.Admin',0,NULL,NULL,'N;'),('Pos.AdminRecycled',0,NULL,NULL,'N;'),('Pos.AuthorizationCheck',0,NULL,NULL,'N;'),('Pos.AuthorizationCheckReprint',0,NULL,NULL,'N;'),('Pos.AuthorizationCheckUpdate',0,NULL,NULL,'N;'),('Pos.AuthorizationCheckVoid',0,NULL,NULL,'N;'),('Pos.Create',0,NULL,NULL,'N;'),('Pos.DeletePermanently',0,NULL,NULL,'N;'),('Pos.PosReport',0,NULL,NULL,'N;'),('Pos.PosReportView',0,NULL,NULL,'N;'),('Pos.Reprint',0,NULL,NULL,'N;'),('Pos.SoReportOfThis',0,NULL,NULL,'N;'),('Pos.SoReportOfThisNonPosUser',0,NULL,NULL,'N;'),('Pos.TempDelete',0,NULL,NULL,'N;'),('Pos.TempDeleteUndo',0,NULL,NULL,'N;'),('Pos.UpdateFromPos',0,NULL,NULL,'N;'),('Pos.Void',0,NULL,NULL,'N;'),('Pos.VoidPos',0,NULL,NULL,'N;'),('Pos.VoidPosUndo',0,NULL,NULL,'N;'),('Pos.VoidUpdate',0,NULL,NULL,'N;'),('ProductionInput.*',1,NULL,NULL,'N;'),('ProductionInput.Admin',0,NULL,NULL,'N;'),('ProductionInput.AdminOutput',0,NULL,NULL,'N;'),('ProductionInput.AdminReturn',0,NULL,NULL,'N;'),('ProductionInput.AdminWastage',0,NULL,NULL,'N;'),('ProductionInput.ConsumptionReport',0,NULL,NULL,'N;'),('ProductionInput.ConsumptionReportView',0,NULL,NULL,'N;'),('ProductionInput.Create',0,NULL,NULL,'N;'),('ProductionInput.Delete',0,NULL,NULL,'N;'),('ProductionInput.DeleteAll',0,NULL,NULL,'N;'),('ProductionInput.DeleteFromUpdate',0,NULL,NULL,'N;'),('ProductionInput.ReturnQty',0,NULL,NULL,'N;'),('ProductionInput.Update',0,NULL,NULL,'N;'),('ProductionOutput.*',1,NULL,NULL,'N;'),('ProductionOutput.Admin',0,NULL,NULL,'N;'),('ProductionOutput.Create',0,NULL,NULL,'N;'),('ProductionOutput.Delete',0,NULL,NULL,'N;'),('ProductionOutput.DeleteAll',0,NULL,NULL,'N;'),('ProductionOutput.ProductionReport',0,NULL,NULL,'N;'),('ProductionOutput.ProductionReportView',0,NULL,NULL,'N;'),('ProductionOutput.Update',0,NULL,NULL,'N;'),('ProductionWastage.*',1,NULL,NULL,'N;'),('ProductionWastage.Admin',0,NULL,NULL,'N;'),('ProductionWastage.Create',0,NULL,NULL,'N;'),('ProductionWastage.Delete',0,NULL,NULL,'N;'),('ProductionWastage.DeleteAll',0,NULL,NULL,'N;'),('ProductionWastage.Update',0,NULL,NULL,'N;'),('PurchaseOrder.*',1,NULL,NULL,'N;'),('PurchaseOrder.Admin',0,NULL,NULL,'N;'),('PurchaseOrder.AdminPO',0,NULL,NULL,'N;'),('PurchaseOrder.CreateAll',0,NULL,NULL,'N;'),('PurchaseOrder.CreateFromSelected',0,NULL,NULL,'N;'),('PurchaseOrder.Delete',0,NULL,NULL,'N;'),('PurchaseOrder.DeleteAll',0,NULL,NULL,'N;'),('PurchaseOrder.RequisitionPreview',0,NULL,NULL,'N;'),('PurchaseOrder.Update',0,NULL,NULL,'N;'),('PurchaseProcurement.*',1,NULL,NULL,'N;'),('PurchaseProcurement.Admin',0,NULL,NULL,'N;'),('PurchaseProcurement.Create',0,NULL,NULL,'N;'),('PurchaseProcurement.Delete',0,NULL,NULL,'N;'),('PurchaseProcurement.DeleteAll',0,NULL,NULL,'N;'),('PurchaseProcurement.DeleteFromUpdate',0,NULL,NULL,'N;'),('PurchaseProcurement.ProcurementPreview',0,NULL,NULL,'N;'),('PurchaseProcurement.Update',0,NULL,NULL,'N;'),('PurchaseRcvRtn.*',1,NULL,NULL,'N;'),('PurchaseRcvRtn.Admin',0,NULL,NULL,'N;'),('PurchaseRcvRtn.AdminReceive',0,NULL,NULL,'N;'),('PurchaseRcvRtn.AllReceive',0,NULL,NULL,'N;'),('PurchaseRcvRtn.Delete',0,NULL,NULL,'N;'),('PurchaseRcvRtn.DeleteAll',0,NULL,NULL,'N;'),('PurchaseRcvRtn.ReceiveHistory',0,NULL,NULL,'N;'),('PurchaseRcvRtn.Return',0,NULL,NULL,'N;'),('PurchaseRcvRtn.Update',0,NULL,NULL,'N;'),('PurchaseRequisition.*',1,NULL,NULL,'N;'),('PurchaseRequisition.Admin',0,NULL,NULL,'N;'),('PurchaseRequisition.AdminPP',0,NULL,NULL,'N;'),('PurchaseRequisition.AdminPRFromSR',0,NULL,NULL,'N;'),('PurchaseRequisition.Create',0,NULL,NULL,'N;'),('PurchaseRequisition.Delete',0,NULL,NULL,'N;'),('PurchaseRequisition.DeleteAll',0,NULL,NULL,'N;'),('PurchaseRequisition.DeleteFromUpdate',0,NULL,NULL,'N;'),('PurchaseRequisition.PurchaseReport',0,NULL,NULL,'N;'),('PurchaseRequisition.PurchaseReportView',0,NULL,NULL,'N;'),('PurchaseRequisition.ReqFromItemsWarningQty',0,NULL,NULL,'N;'),('PurchaseRequisition.ReqFromItemsWarningQtyView',0,NULL,NULL,'N;'),('PurchaseRequisition.ReqFromItemsWarnQtyCreate',0,NULL,NULL,'N;'),('PurchaseRequisition.ReqFromSO',0,NULL,NULL,'N;'),('PurchaseRequisition.ReqFromSoCreate',0,NULL,NULL,'N;'),('PurchaseRequisition.ReqFromSOView',0,NULL,NULL,'N;'),('PurchaseRequisition.ReqFromStoreReq',0,NULL,NULL,'N;'),('PurchaseRequisition.RequisitionPreview',0,NULL,NULL,'N;'),('PurchaseRequisition.Update',0,NULL,NULL,'N;'),('ReportPdf.*',1,NULL,NULL,'N;'),('ReportPdf.ConsumptionReportPdf',0,NULL,NULL,'N;'),('ReportPdf.CustomerLedgerAllPdf',0,NULL,NULL,'N;'),('ReportPdf.CustomerLedgerSpecificPdf',0,NULL,NULL,'N;'),('ReportPdf.PosReportPdf',0,NULL,NULL,'N;'),('ReportPdf.ProductionReportPdf',0,NULL,NULL,'N;'),('ReportPdf.PurchaseReportPdf',0,NULL,NULL,'N;'),('ReportPdf.SalesReportPdf',0,NULL,NULL,'N;'),('ReportPdf.StockReportPdf',0,NULL,NULL,'N;'),('ReportPdf.StockReportStorePdf',0,NULL,NULL,'N;'),('ReportPdf.StoreReqReportPdf',0,NULL,NULL,'N;'),('ReportPdf.SupplierLedgerAllPdf',0,NULL,NULL,'N;'),('ReportPdf.SupplierLedgerSpecificPdf',0,NULL,NULL,'N;'),('ReportXls.*',1,NULL,NULL,'N;'),('ReportXls.Index',0,NULL,NULL,'N;'),('SaleOrder.*',1,NULL,NULL,'N;'),('SaleOrder.Admin',0,NULL,NULL,'N;'),('SaleOrder.Create',0,NULL,NULL,'N;'),('SaleOrder.Delete',0,NULL,NULL,'N;'),('SaleOrder.DeleteAll',0,NULL,NULL,'N;'),('SaleOrder.DeleteFromUpdate',0,NULL,NULL,'N;'),('SaleOrder.SalesReport',0,NULL,NULL,'N;'),('SaleOrder.SalesReportView',0,NULL,NULL,'N;'),('SaleOrder.SoPreview',0,NULL,NULL,'N;'),('SaleOrder.Start',0,NULL,NULL,'N;'),('SaleOrder.Stop',0,NULL,NULL,'N;'),('SaleOrder.Update',0,NULL,NULL,'N;'),('SellDelvRtn.*',1,NULL,NULL,'N;'),('SellDelvRtn.Admin',0,NULL,NULL,'N;'),('SellDelvRtn.AdminDelivery',0,NULL,NULL,'N;'),('SellDelvRtn.AllDeliver',0,NULL,NULL,'N;'),('SellDelvRtn.ChallanNoPreview',0,NULL,NULL,'N;'),('SellDelvRtn.Delete',0,NULL,NULL,'N;'),('SellDelvRtn.DeleteAll',0,NULL,NULL,'N;'),('SellDelvRtn.DeliveryHistory',0,NULL,NULL,'N;'),('SellDelvRtn.Return',0,NULL,NULL,'N;'),('SellDelvRtn.Update',0,NULL,NULL,'N;'),('SellingPrice.*',1,NULL,NULL,'N;'),('SellingPrice.AddSellingPrice',0,NULL,NULL,'N;'),('SellingPrice.Admin',0,NULL,NULL,'N;'),('SellingPrice.Delete',0,NULL,NULL,'N;'),('SellingPrice.PriceHistory',0,NULL,NULL,'N;'),('SellingPrice.Update',0,NULL,NULL,'N;'),('Site.*',1,NULL,NULL,'N;'),('Site.DashBoard',0,NULL,NULL,'N;'),('Site.Error',0,NULL,NULL,'N;'),('Site.Index',0,NULL,NULL,'N;'),('Site.Login',0,NULL,NULL,'N;'),('Site.Logout',0,NULL,NULL,'N;'),('StockTransferHistory.*',1,NULL,NULL,'N;'),('StockTransferHistory.Admin',0,NULL,NULL,'N;'),('StockTransferHistory.AdminForReceive',0,NULL,NULL,'N;'),('StockTransferHistory.Delete',0,NULL,NULL,'N;'),('StockTransferHistory.ReceiveStock',0,NULL,NULL,'N;'),('StockTransferHistory.Update',0,NULL,NULL,'N;'),('StorckTranferHistoryFromTempToMain.*',1,NULL,NULL,'N;'),('StorckTranferHistoryFromTempToMain.Admin',0,NULL,NULL,'N;'),('StorckTranferHistoryFromTempToMain.Delete',0,NULL,NULL,'N;'),('StorckTranferHistoryFromTempToMain.Update',0,NULL,NULL,'N;'),('StoreInventory.*',1,NULL,NULL,'N;'),('StoreInventory.Admin',0,NULL,NULL,'N;'),('StoreInventory.Create',0,NULL,NULL,'N;'),('StoreInventory.Delete',0,NULL,NULL,'N;'),('StoreInventory.DeleteAll',0,NULL,NULL,'N;'),('StoreInventory.SendFromTempToMainInv',0,NULL,NULL,'N;'),('StoreInventory.SendFromTempToMainInvView',0,NULL,NULL,'N;'),('StoreInventory.StockReport',0,NULL,NULL,'N;'),('StoreInventory.StockReportView',0,NULL,NULL,'N;'),('StoreInventory.TransferStockFromTempToMainInvCreate',0,NULL,NULL,'N;'),('StoreInventory.Update',0,NULL,NULL,'N;'),('StoreReqDR.*',1,NULL,NULL,'N;'),('StoreReqDR.Admin',0,NULL,NULL,'N;'),('StoreReqDR.AdminApprove',0,NULL,NULL,'N;'),('StoreReqDR.AdminDelivery',0,NULL,NULL,'N;'),('StoreReqDR.AdminReturn',0,NULL,NULL,'N;'),('StoreReqDR.AllApprove',0,NULL,NULL,'N;'),('StoreReqDR.AllDelivery',0,NULL,NULL,'N;'),('StoreReqDR.Delete',0,NULL,NULL,'N;'),('StoreReqDR.DeleteAll',0,NULL,NULL,'N;'),('StoreReqDR.Return',0,NULL,NULL,'N;'),('StoreReqDR.Update',0,NULL,NULL,'N;'),('StoreRequisition.*',1,NULL,NULL,'N;'),('StoreRequisition.Admin',0,NULL,NULL,'N;'),('StoreRequisition.Create',0,NULL,NULL,'N;'),('StoreRequisition.Delete',0,NULL,NULL,'N;'),('StoreRequisition.DeleteAll',0,NULL,NULL,'N;'),('StoreRequisition.DeleteFromUpdate',0,NULL,NULL,'N;'),('StoreRequisition.RequisitionPreview',0,NULL,NULL,'N;'),('StoreRequisition.StoreReqReport',0,NULL,NULL,'N;'),('StoreRequisition.StoreReqReportView',0,NULL,NULL,'N;'),('StoreRequisition.Update',0,NULL,NULL,'N;'),('Stores.*',1,NULL,NULL,'N;'),('Stores.Admin',0,NULL,NULL,'N;'),('Stores.Create',0,NULL,NULL,'N;'),('Stores.CreateStoreFromOutSide',0,NULL,NULL,'N;'),('Stores.Delete',0,NULL,NULL,'N;'),('Stores.Update',0,NULL,NULL,'N;'),('Sub Admin',2,'Sub Admin',NULL,'N;'),('SuperAdmin',2,NULL,NULL,'N;'),('SupplierContactPersons.*',1,NULL,NULL,'N;'),('SupplierContactPersons.AddContactPerson',0,NULL,NULL,'N;'),('SupplierContactPersons.Admin',0,NULL,NULL,'N;'),('SupplierContactPersons.Contacts',0,NULL,NULL,'N;'),('SupplierContactPersons.Create',0,NULL,NULL,'N;'),('SupplierContactPersons.Delete',0,NULL,NULL,'N;'),('SupplierContactPersons.Update',0,NULL,NULL,'N;'),('SupplierMr.*',1,NULL,NULL,'N;'),('SupplierMr.AddMoneyReceipt',0,NULL,NULL,'N;'),('SupplierMr.Admin',0,NULL,NULL,'N;'),('SupplierMr.Delete',0,NULL,NULL,'N;'),('SupplierMr.DeleteAll',0,NULL,NULL,'N;'),('SupplierMr.MoneyReceiptHistory',0,NULL,NULL,'N;'),('SupplierMr.MrPreview',0,NULL,NULL,'N;'),('SupplierMr.Update',0,NULL,NULL,'N;'),('Suppliers.*',1,NULL,NULL,'N;'),('Suppliers.Admin',0,NULL,NULL,'N;'),('Suppliers.AdminMoneyReceipt',0,NULL,NULL,'N;'),('Suppliers.Create',0,NULL,NULL,'N;'),('Suppliers.CreateSupplierFromOutSide',0,NULL,NULL,'N;'),('Suppliers.Delete',0,NULL,NULL,'N;'),('Suppliers.SupplierLedgerAll',0,NULL,NULL,'N;'),('Suppliers.SupplierLedgerAllView',0,NULL,NULL,'N;'),('Suppliers.SupplierLedgerSpecific',0,NULL,NULL,'N;'),('Suppliers.SupplierLedgerSpecificView',0,NULL,NULL,'N;'),('Suppliers.Update',0,NULL,NULL,'N;'),('Suppliers.View',0,NULL,NULL,'N;'),('Users.*',1,NULL,NULL,'N;'),('Users.Admin',0,NULL,NULL,'N;'),('Users.AdminAssignStore',0,NULL,NULL,'N;'),('Users.Create',0,NULL,NULL,'N;'),('Users.Delete',0,NULL,NULL,'N;'),('Users.Update',0,NULL,NULL,'N;'),('UserStore.*',1,NULL,NULL,'N;'),('UserStore.Admin',0,NULL,NULL,'N;'),('UserStore.AssignStoreToThisUser',0,NULL,NULL,'N;'),('UserStore.ChangeStatus',0,NULL,NULL,'N;'),('UserStore.Delete',0,NULL,NULL,'N;'),('UserStore.Update',0,NULL,NULL,'N;'),('YourCompany.*',1,NULL,NULL,'N;'),('YourCompany.Admin',0,NULL,NULL,'N;'),('YourCompany.Create',0,NULL,NULL,'N;'),('YourCompany.Delete',0,NULL,NULL,'N;'),('YourCompany.Update',0,NULL,NULL,'N;');

/*Table structure for table `AuthItemChild` */

DROP TABLE IF EXISTS `AuthItemChild`;

CREATE TABLE `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `AuthItemChild` */

insert  into `AuthItemChild`(`parent`,`child`) values ('POS User','Members.AvailablePointsOfThis'),('POS User','Members.CreateMembersFromOutSide'),('POS User','Members.MembersAVpoint'),('POS User','Pos.AuthorizationCheck'),('POS User','Pos.AuthorizationCheckReprint'),('POS User','Pos.AuthorizationCheckUpdate'),('POS User','Pos.AuthorizationCheckVoid'),('POS User','Pos.Create'),('POS User','Pos.Reprint'),('POS User','Pos.SoReportOfThis'),('POS User','Pos.Void'),('POS User','Pos.VoidPos'),('POS User','Pos.VoidPosUndo'),('POS User','Pos.VoidUpdate');

/*Table structure for table `banks` */

DROP TABLE IF EXISTS `banks`;

CREATE TABLE `banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `banks` */

/*Table structure for table `cats` */

DROP TABLE IF EXISTS `cats`;

CREATE TABLE `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `cats` */

insert  into `cats`(`id`,`name`) values (1,'Shirt'),(2,'T-Shirt'),(3,'Pant'),(4,'Perfume'),(5,'Rice'),(6,'Basic Sheet');

/*Table structure for table `cats_sub` */

DROP TABLE IF EXISTS `cats_sub`;

CREATE TABLE `cats_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `cats_sub` */

insert  into `cats_sub`(`id`,`name`) values (1,'Ladies'),(2,'Gents'),(3,'Child'),(4,'Hybrid'),(5,'LDPE Foam');

/*Table structure for table `costing_price` */

DROP TABLE IF EXISTS `costing_price`;

CREATE TABLE `costing_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_costing_price` (`item`),
  CONSTRAINT `FK_costing_price` FOREIGN KEY (`item`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `costing_price` */

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso2` char(2) DEFAULT NULL,
  `iso3` char(3) DEFAULT NULL,
  `country` varchar(62) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

/*Data for the table `countries` */

insert  into `countries`(`id`,`iso2`,`iso3`,`country`) values (1,'AF','AFG','Afghanistan'),(2,'AX','ALA','Åland Islands'),(3,'AL','ALB','Albania'),(4,'DZ','DZA','Algeria (El Djazaïr)'),(5,'AS','ASM','American Samoa'),(6,'AD','AND','Andorra'),(7,'AO','AGO','Angola'),(8,'AI','AIA','Anguilla'),(9,'AQ','ATA','Antarctica'),(10,'AG','ATG','Antigua and Barbuda'),(11,'AR','ARG','Argentina'),(12,'AM','ARM','Armenia'),(13,'AW','ABW','Aruba'),(14,'AU','AUS','Australia'),(15,'AT','AUT','Austria'),(16,'AZ','AZE','Azerbaijan'),(17,'BS','BHS','Bahamas'),(18,'BH','BHR','Bahrain'),(19,'BD','BGD','Bangladesh'),(20,'BB','BRB','Barbados'),(21,'BY','BLR','Belarus'),(22,'BE','BEL','Belgium'),(23,'BZ','BLZ','Belize'),(24,'BJ','BEN','Benin'),(25,'BM','BMU','Bermuda'),(26,'BT','BTN','Bhutan'),(27,'BO','BOL','Bolivia'),(28,'BA','BIH','Bosnia and Herzegovina'),(29,'BW','BWA','Botswana'),(30,'BV','BVT','Bouvet Island'),(31,'BR','BRA','Brazil'),(32,'IO','IOT','British Indian Ocean Territory'),(33,'BN','BRN','Brunei Darussalam'),(34,'BG','BGR','Bulgaria'),(35,'BF','BFA','Burkina Faso'),(36,'BI','BDI','Burundi'),(37,'KH','KHM','Cambodia'),(38,'CM','CMR','Cameroon'),(39,'CA','CAN','Canada'),(40,'CV','CPV','Cape Verde'),(41,'KY','CYM','Cayman Islands'),(42,'CF','CAF','Central African Republic'),(43,'TD','TCD','Chad (T\'Chad)'),(44,'CL','CHL','Chile'),(45,'CN','CHN','China'),(46,'CX','CXR','Christmas Island'),(47,'CC','CCK','Cocos (Keeling) Islands'),(48,'CO','COL','Colombia'),(49,'KM','COM','Comoros'),(50,'CG','COG','Congo, Republic Of'),(51,'CD','COD','Congo, The Democratic Republic of the (formerly Zaire)'),(52,'CK','COK','Cook Islands'),(53,'CR','CRI','Costa Rica'),(54,'CI','CIV','CÔte D\'Ivoire (Ivory Coast)'),(55,'HR','HRV','Croatia (hrvatska)'),(56,'CU','CUB','Cuba'),(57,'CY','CYP','Cyprus'),(58,'CZ','CZE','Czech Republic'),(59,'DK','DNK','Denmark'),(60,'DJ','DJI','Djibouti'),(61,'DM','DMA','Dominica'),(62,'DO','DOM','Dominican Republic'),(63,'EC','ECU','Ecuador'),(64,'EG','EGY','Egypt'),(65,'SV','SLV','El Salvador'),(66,'GQ','GNQ','Equatorial Guinea'),(67,'ER','ERI','Eritrea'),(68,'EE','EST','Estonia'),(69,'ET','ETH','Ethiopia'),(70,'FO','FRO','Faeroe Islands'),(71,'FK','FLK','Falkland Islands (Malvinas)'),(72,'FJ','FJI','Fiji'),(73,'FI','FIN','Finland'),(74,'FR','FRA','France'),(75,'GF','GUF','French Guiana'),(76,'PF','PYF','French Polynesia'),(77,'TF','ATF','French Southern Territories'),(78,'GA','GAB','Gabon'),(79,'GM','GMB','Gambia, The'),(80,'GE','GEO','Georgia'),(81,'DE','DEU','Germany (Deutschland)'),(82,'GH','GHA','Ghana'),(83,'GI','GIB','Gibraltar'),(84,'GB','GBR','Great Britain'),(85,'GR','GRC','Greece'),(86,'GL','GRL','Greenland'),(87,'GD','GRD','Grenada'),(88,'GP','GLP','Guadeloupe'),(89,'GU','GUM','Guam'),(90,'GT','GTM','Guatemala'),(91,'GN','GIN','Guinea'),(92,'GW','GNB','Guinea-bissau'),(93,'GY','GUY','Guyana'),(94,'HT','HTI','Haiti'),(95,'HM','HMD','Heard Island and Mcdonald Islands'),(96,'HN','HND','Honduras'),(97,'HK','HKG','Hong Kong (Special Administrative Region of China)'),(98,'HU','HUN','Hungary'),(99,'IS','ISL','Iceland'),(100,'IN','IND','India'),(101,'ID','IDN','Indonesia'),(102,'IR','IRN','Iran (Islamic Republic of Iran)'),(103,'IQ','IRQ','Iraq'),(104,'IE','IRL','Ireland'),(105,'IL','ISR','Israel'),(106,'IT','ITA','Italy'),(107,'JM','JAM','Jamaica'),(108,'JP','JPN','Japan'),(109,'JO','JOR','Jordan (Hashemite Kingdom of Jordan)'),(110,'KZ','KAZ','Kazakhstan'),(111,'KE','KEN','Kenya'),(112,'KI','KIR','Kiribati'),(113,'KP','PRK','Korea (Democratic Peoples Republic pf [North] Korea)'),(114,'KR','KOR','Korea (Republic of [South] Korea)'),(115,'KW','KWT','Kuwait'),(116,'KG','KGZ','Kyrgyzstan'),(117,'LA','LAO','Lao People\'s Democratic Republic'),(118,'LV','LVA','Latvia'),(119,'LB','LBN','Lebanon'),(120,'LS','LSO','Lesotho'),(121,'LR','LBR','Liberia'),(122,'LY','LBY','Libya (Libyan Arab Jamahirya)'),(123,'LI','LIE','Liechtenstein (Fürstentum Liechtenstein)'),(124,'LT','LTU','Lithuania'),(125,'LU','LUX','Luxembourg'),(126,'MO','MAC','Macao (Special Administrative Region of China)'),(127,'MK','MKD','Macedonia (Former Yugoslav Republic of Macedonia)'),(128,'MG','MDG','Madagascar'),(129,'MW','MWI','Malawi'),(130,'MY','MYS','Malaysia'),(131,'MV','MDV','Maldives'),(132,'ML','MLI','Mali'),(133,'MT','MLT','Malta'),(134,'MH','MHL','Marshall Islands'),(135,'MQ','MTQ','Martinique'),(136,'MR','MRT','Mauritania'),(137,'MU','MUS','Mauritius'),(138,'YT','MYT','Mayotte'),(139,'MX','MEX','Mexico'),(140,'FM','FSM','Micronesia (Federated States of Micronesia)'),(141,'MD','MDA','Moldova'),(142,'MC','MCO','Monaco'),(143,'MN','MNG','Mongolia'),(144,'MS','MSR','Montserrat'),(145,'MA','MAR','Morocco'),(146,'MZ','MOZ','Mozambique (Moçambique)'),(147,'MM','MMR','Myanmar (formerly Burma)'),(148,'NA','NAM','Namibia'),(149,'NR','NRU','Nauru'),(150,'NP','NPL','Nepal'),(151,'NL','NLD','Netherlands'),(152,'AN','ANT','Netherlands Antilles'),(153,'NC','NCL','New Caledonia'),(154,'NZ','NZL','New Zealand'),(155,'NI','NIC','Nicaragua'),(156,'NE','NER','Niger'),(157,'NG','NGA','Nigeria'),(158,'NU','NIU','Niue'),(159,'NF','NFK','Norfolk Island'),(160,'MP','MNP','Northern Mariana Islands'),(161,'NO','NOR','Norway'),(162,'OM','OMN','Oman'),(163,'PK','PAK','Pakistan'),(164,'PW','PLW','Palau'),(165,'PS','PSE','Palestinian Territories'),(166,'PA','PAN','Panama'),(167,'PG','PNG','Papua New Guinea'),(168,'PY','PRY','Paraguay'),(169,'PE','PER','Peru'),(170,'PH','PHL','Philippines'),(171,'PN','PCN','Pitcairn'),(172,'PL','POL','Poland'),(173,'PT','PRT','Portugal'),(174,'PR','PRI','Puerto Rico'),(175,'QA','QAT','Qatar'),(176,'RE','REU','RÉunion'),(177,'RO','ROU','Romania'),(178,'RU','RUS','Russian Federation'),(179,'RW','RWA','Rwanda'),(180,'SH','SHN','Saint Helena'),(181,'KN','KNA','Saint Kitts and Nevis'),(182,'LC','LCA','Saint Lucia'),(183,'PM','SPM','Saint Pierre and Miquelon'),(184,'VC','VCT','Saint Vincent and the Grenadines'),(185,'WS','WSM','Samoa (formerly Western Samoa)'),(186,'SM','SMR','San Marino (Republic of)'),(187,'ST','STP','Sao Tome and Principe'),(188,'SA','SAU','Saudi Arabia (Kingdom of Saudi Arabia)'),(189,'SN','SEN','Senegal'),(190,'CS','SCG','Serbia and Montenegro (formerly Yugoslavia)'),(191,'SC','SYC','Seychelles'),(192,'SL','SLE','Sierra Leone'),(193,'SG','SGP','Singapore'),(194,'SK','SVK','Slovakia (Slovak Republic)'),(195,'SI','SVN','Slovenia'),(196,'SB','SLB','Solomon Islands'),(197,'SO','SOM','Somalia'),(198,'ZA','ZAF','South Africa (zuid Afrika)'),(199,'GS','SGS','South Georgia and the South Sandwich Islands'),(200,'ES','ESP','Spain (españa)'),(201,'LK','LKA','Sri Lanka'),(202,'SD','SDN','Sudan'),(203,'SR','SUR','Suriname'),(204,'SJ','SJM','Svalbard and Jan Mayen'),(205,'SZ','SWZ','Swaziland'),(206,'SE','SWE','Sweden'),(207,'CH','CHE','Switzerland (Confederation of Helvetia)'),(208,'SY','SYR','Syrian Arab Republic'),(209,'TW','TWN','Taiwan (\"Chinese Taipei\" for IOC)'),(210,'TJ','TJK','Tajikistan'),(211,'TZ','TZA','Tanzania'),(212,'TH','THA','Thailand'),(213,'TL','TLS','Timor-Leste (formerly East Timor)'),(214,'TG','TGO','Togo'),(215,'TK','TKL','Tokelau'),(216,'TO','TON','Tonga'),(217,'TT','TTO','Trinidad and Tobago'),(218,'TN','TUN','Tunisia'),(219,'TR','TUR','Turkey'),(220,'TM','TKM','Turkmenistan'),(221,'TC','TCA','Turks and Caicos Islands'),(222,'TV','TUV','Tuvalu'),(223,'UG','UGA','Uganda'),(224,'UA','UKR','Ukraine'),(225,'AE','ARE','United Arab Emirates'),(226,'GB','GBR','United Kingdom (Great Britain)'),(227,'US','USA','United States'),(228,'UM','UMI','United States Minor Outlying Islands'),(229,'UY','URY','Uruguay'),(230,'UZ','UZB','Uzbekistan'),(231,'VU','VUT','Vanuatu'),(232,'VA','VAT','Vatican City (Holy See)'),(233,'VE','VEN','Venezuela'),(234,'VN','VNM','Viet Nam'),(235,'VG','VGB','Virgin Islands, British'),(236,'VI','VIR','Virgin Islands, U.S.'),(237,'WF','WLF','Wallis and Futuna'),(238,'EH','ESH','Western Sahara (formerly Spanish Sahara)'),(239,'YE','YEM','Yemen (Arab Republic)'),(240,'ZM','ZMB','Zambia'),(241,'ZW','ZWE','Zimbabwe');

/*Table structure for table `credit_memo` */

DROP TABLE IF EXISTS `credit_memo`;

CREATE TABLE `credit_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `credit_memo` */

/*Table structure for table `customer_bill` */

DROP TABLE IF EXISTS `customer_bill`;

CREATE TABLE `customer_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `challan_no` varchar(255) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `customer_bill` */

insert  into `customer_bill`(`id`,`max_sl_no`,`sl_no`,`customer_id`,`challan_no`,`bill_date`,`due_date`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (20,1,'201601241',1,'201601241','2016-01-24','2016-01-24',1,'2016-01-24 01:19:15',NULL,NULL),(21,1,'201601241',1,'201601242','2016-01-24','2016-01-24',1,'2016-01-24 01:19:15',NULL,NULL),(22,1,'201601241',1,'201601243','2016-01-24','2016-01-24',1,'2016-01-24 01:19:15',NULL,NULL),(23,1,'201601241',1,'201601244','2016-01-24','2016-01-24',1,'2016-01-24 01:19:15',NULL,NULL),(24,2,'201601242',1,'201601245','2016-01-24','2016-01-24',1,'2016-01-24 11:22:08',NULL,NULL),(25,2,'201601242',1,'201601246','2016-01-24','2016-01-24',1,'2016-01-24 11:22:08',NULL,NULL),(26,2,'201601242',1,'201601247','2016-01-24','2016-01-24',1,'2016-01-24 11:22:08',NULL,NULL);

/*Table structure for table `customer_contact_persons` */

DROP TABLE IF EXISTS `customer_contact_persons`;

CREATE TABLE `customer_contact_persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `contact_number1` varchar(20) DEFAULT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `contact_number3` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contact_persons2` (`company_id`),
  KEY `FK_contact_persons_designation` (`designation_id`),
  CONSTRAINT `FK_contact_persons` FOREIGN KEY (`company_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `customer_contact_persons` */

insert  into `customer_contact_persons`(`id`,`company_id`,`contact_person_name`,`designation_id`,`contact_number1`,`contact_number2`,`contact_number3`,`email`) values (1,1,'Contact Person One',1,'123456789','','','');

/*Table structure for table `customer_mr` */

DROP TABLE IF EXISTS `customer_mr`;

CREATE TABLE `customer_mr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `received_type` int(11) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `discount` double DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `customer_mr` */

insert  into `customer_mr`(`id`,`max_sl_no`,`sl_no`,`bill_no`,`customer_id`,`date`,`received_type`,`bank_name`,`cheque_no`,`cheque_date`,`paid_amount`,`discount`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (5,1,'201601241','201601241',1,'2016-01-24',20,'','','0000-00-00',73499.11,0,1,'2016-01-24 01:19:49',NULL,NULL),(6,2,'201601242','201601242',1,'2016-01-24',20,'','','0000-00-00',54506.29,0,1,'2016-01-24 11:28:03',NULL,NULL);

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_no` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text,
  `company_contact_no` varchar(20) DEFAULT NULL,
  `company_fax` varchar(20) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_web` varchar(50) DEFAULT NULL,
  `opening_amount` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `customers` */

insert  into `customers`(`id`,`id_no`,`company_name`,`company_address`,`company_contact_no`,`company_fax`,`company_email`,`company_web`,`opening_amount`) values (1,'20160120110127','Customer One','','','','','',0);

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `departments` */

insert  into `departments`(`id`,`department_name`) values (1,'Department One');

/*Table structure for table `designations` */

DROP TABLE IF EXISTS `designations`;

CREATE TABLE `designations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `designations` */

insert  into `designations`(`id`,`designation`) values (1,'Designation One');

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `employees` */

insert  into `employees`(`id`,`full_name`,`designation_id`,`department_id`,`id_no`,`contact_no`,`email`,`address`) values (1,'Employee One',1,1,'20160120110111','123456789','',''),(2,'Md Mohallil Haque Tanim',1,1,'20160127020123','111111','','');

/*Table structure for table `grades` */

DROP TABLE IF EXISTS `grades`;

CREATE TABLE `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `grades` */

insert  into `grades`(`id`,`name`) values (1,'Grade One');

/*Table structure for table `import_document` */

DROP TABLE IF EXISTS `import_document`;

CREATE TABLE `import_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lc_id` int(11) DEFAULT NULL,
  `pi_no` varchar(255) DEFAULT NULL,
  `pi_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_import_document` (`lc_id`),
  CONSTRAINT `FK_import_document` FOREIGN KEY (`lc_id`) REFERENCES `master_lc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `import_document` */

/*Table structure for table `inventory` */

DROP TABLE IF EXISTS `inventory`;

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `stock_in` double DEFAULT NULL,
  `stock_out` double DEFAULT NULL,
  `costing_price` double DEFAULT NULL,
  `sell_price` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

/*Data for the table `inventory` */

insert  into `inventory`(`id`,`date`,`store`,`item`,`stock_in`,`stock_out`,`costing_price`,`sell_price`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (1,'2016-01-21',1,1,100000,NULL,550,NULL,1,'2016-01-21 04:57:31',NULL,NULL),(2,'2016-01-21',1,2,100000,NULL,550,NULL,1,'2016-01-21 04:57:31',NULL,NULL),(3,'2016-01-21',1,1,NULL,10,NULL,NULL,1,'2016-01-21 05:00:32',NULL,NULL),(4,'2016-01-21',1,2,NULL,10,NULL,NULL,1,'2016-01-21 05:00:32',NULL,NULL),(5,'2016-01-21',1,2,NULL,5,NULL,NULL,1,'2016-01-21 05:02:27',NULL,NULL),(6,'2016-01-21',1,2,NULL,1,NULL,NULL,1,'2016-01-21 05:03:37',NULL,NULL),(7,'2016-01-21',1,3,100000,NULL,50,NULL,1,'2016-01-21 16:06:10',NULL,NULL),(8,'2016-01-21',1,3,NULL,10,NULL,NULL,1,'2016-01-21 16:06:24',NULL,NULL),(9,'2016-01-21',1,2,NULL,1,NULL,NULL,1,'2016-01-21 16:13:11',NULL,NULL),(10,'2016-01-23',1,1,NULL,2,NULL,NULL,1,'2016-01-23 21:09:06',NULL,NULL),(11,'2016-01-23',1,3,NULL,2,NULL,NULL,1,'2016-01-23 21:09:06',NULL,NULL),(12,'2016-01-23',1,2,NULL,2,NULL,NULL,1,'2016-01-23 21:38:35',NULL,NULL),(13,'2016-01-23',1,1,NULL,2,NULL,NULL,1,'2016-01-23 21:38:35',NULL,NULL),(14,'2016-01-23',1,2,NULL,10,NULL,NULL,1,'2016-01-23 21:40:37',NULL,NULL),(15,'2016-01-23',1,1,NULL,15,NULL,NULL,1,'2016-01-23 21:41:46',NULL,NULL),(16,'2016-01-23',1,1,100000,NULL,550,NULL,1,'2016-01-23 22:30:18',NULL,NULL),(17,'2016-01-23',1,2,100000,NULL,550,NULL,1,'2016-01-23 22:30:18',NULL,NULL),(18,'2016-01-23',1,4,10000,NULL,10,NULL,1,'2016-01-23 23:23:45',NULL,NULL),(19,'2016-01-23',1,4,NULL,10,NULL,NULL,1,'2016-01-23 23:23:55',NULL,NULL),(20,'2016-01-23',1,3,NULL,5,NULL,NULL,1,'2016-01-23 23:38:45',NULL,NULL),(21,'2016-01-23',1,3,NULL,5,NULL,NULL,1,'2016-01-23 23:40:00',NULL,NULL),(22,'2016-01-23',1,2,NULL,1,NULL,NULL,1,'2016-01-23 23:42:40',NULL,NULL),(23,'2016-01-23',1,1,NULL,3,NULL,NULL,1,'2016-01-23 23:53:36',NULL,NULL),(24,'2016-01-23',1,3,NULL,3,NULL,NULL,1,'2016-01-23 23:53:36',NULL,NULL),(25,'2016-01-23',1,2,NULL,3,NULL,NULL,1,'2016-01-23 23:53:36',NULL,NULL),(26,'2016-01-23',1,1,3,NULL,NULL,NULL,1,'2016-01-24 00:02:35',NULL,NULL),(27,'2016-01-23',1,3,3,NULL,NULL,NULL,1,'2016-01-24 00:02:36',NULL,NULL),(28,'2016-01-23',1,2,3,NULL,NULL,NULL,1,'2016-01-24 00:02:36',NULL,NULL),(29,'2016-01-24',1,1,NULL,2,NULL,NULL,1,'2016-01-24 00:03:33',NULL,NULL),(30,'2016-01-24',1,3,NULL,2,NULL,NULL,1,'2016-01-24 00:03:33',NULL,NULL),(31,'2016-01-24',1,2,NULL,2,NULL,NULL,1,'2016-01-24 00:03:33',NULL,NULL),(32,'2016-01-24',1,1,NULL,1,NULL,NULL,1,'2016-01-24 00:04:10',NULL,NULL),(33,'2016-01-24',1,3,NULL,1,NULL,NULL,1,'2016-01-24 00:04:11',NULL,NULL),(34,'2016-01-24',1,2,NULL,1,NULL,NULL,1,'2016-01-24 00:04:11',NULL,NULL),(35,'2016-01-24',1,1,1,NULL,NULL,NULL,1,'2016-01-24 00:05:57',NULL,NULL),(36,'2016-01-24',1,3,1,NULL,NULL,NULL,1,'2016-01-24 00:05:57',NULL,NULL),(37,'2016-01-24',1,2,1,NULL,NULL,NULL,1,'2016-01-24 00:05:57',NULL,NULL),(38,'2016-01-24',1,1,2,NULL,NULL,NULL,1,'2016-01-24 00:05:57',NULL,NULL),(39,'2016-01-24',1,3,2,NULL,NULL,NULL,1,'2016-01-24 00:05:57',NULL,NULL),(40,'2016-01-24',1,2,2,NULL,NULL,NULL,1,'2016-01-24 00:05:57',NULL,NULL),(41,'2016-01-24',1,4,NULL,3,NULL,NULL,1,'2016-01-24 00:06:40',NULL,NULL),(42,'2016-01-24',1,4,NULL,3,NULL,NULL,1,'2016-01-24 00:06:58',NULL,NULL),(43,'2016-01-24',1,4,NULL,3,NULL,NULL,1,'2016-01-24 00:07:13',NULL,NULL),(44,'2016-01-24',1,4,NULL,1,NULL,NULL,1,'2016-01-24 00:07:23',NULL,NULL),(45,'2016-01-24',1,4,NULL,3,NULL,NULL,1,'2016-01-24 00:33:30',NULL,NULL),(46,'2016-01-24',1,4,NULL,3,NULL,NULL,1,'2016-01-24 00:33:44',NULL,NULL),(47,'2016-01-24',1,4,NULL,3,NULL,NULL,1,'2016-01-24 00:33:54',NULL,NULL),(48,'2016-01-24',1,4,NULL,1,NULL,NULL,1,'2016-01-24 00:34:03',NULL,NULL),(49,'2016-01-24',1,2,NULL,2,NULL,NULL,1,'2016-01-24 01:03:11',NULL,NULL),(50,'2016-01-24',1,2,NULL,2,NULL,NULL,1,'2016-01-24 01:03:24',NULL,NULL),(51,'2016-01-24',1,2,NULL,2,NULL,NULL,1,'2016-01-24 01:03:34',NULL,NULL),(52,'2016-01-24',1,4,NULL,5,NULL,NULL,1,'2016-01-24 01:11:57',NULL,NULL),(53,'2016-01-24',1,4,NULL,5,NULL,NULL,1,'2016-01-24 01:12:07',NULL,NULL),(54,'2016-01-24',1,4,NULL,10,NULL,NULL,1,'2016-01-24 01:17:44',NULL,NULL),(55,'2016-01-24',1,2,NULL,6,NULL,NULL,1,'2016-01-24 01:17:56',NULL,NULL),(56,'2016-01-24',1,4,NULL,10,NULL,NULL,1,'2016-01-24 01:18:09',NULL,NULL),(57,'2016-01-24',1,1,NULL,3,NULL,NULL,1,'2016-01-24 01:18:25',NULL,NULL),(58,'2016-01-24',1,3,NULL,3,NULL,NULL,1,'2016-01-24 01:18:25',NULL,NULL),(59,'2016-01-24',1,2,NULL,3,NULL,NULL,1,'2016-01-24 01:18:25',NULL,NULL),(60,'2016-01-24',1,3,NULL,5,NULL,NULL,1,'2016-01-24 11:20:28',NULL,NULL),(61,'2016-01-24',1,3,NULL,5,NULL,NULL,1,'2016-01-24 11:20:40',NULL,NULL),(62,'2016-01-24',1,4,NULL,5,NULL,NULL,1,'2016-01-24 11:20:52',NULL,NULL),(63,'2016-01-25',1,7,1000,NULL,80,NULL,1,'2016-01-25 20:22:58',NULL,NULL),(64,'2016-01-25',1,5,1000,NULL,80,NULL,1,'2016-01-25 20:22:58',NULL,NULL),(65,'2016-01-25',1,6,1000,NULL,80,NULL,1,'2016-01-25 20:22:58',NULL,NULL),(66,'2016-01-25',1,4,NULL,1,NULL,250,1,'2016-01-25 20:24:55',NULL,NULL),(67,'2016-01-25',1,7,NULL,1,NULL,100,1,'2016-01-25 20:24:55',NULL,NULL),(68,'2016-01-25',1,5,NULL,1,NULL,100,1,'2016-01-25 20:24:55',NULL,NULL),(69,'2016-01-25',1,6,NULL,1,NULL,100,1,'2016-01-25 20:24:55',NULL,NULL),(70,'2016-01-25',1,2,NULL,1,NULL,150,1,'2016-01-25 20:24:56',NULL,NULL),(71,'2016-01-25',1,1,NULL,1,NULL,160,1,'2016-01-25 20:24:56',NULL,NULL),(72,'2016-01-25',1,3,NULL,1,NULL,100,1,'2016-01-25 20:24:56',NULL,NULL),(73,'2016-01-25',1,8,NULL,1,NULL,200,1,'2016-01-25 20:24:56',NULL,NULL),(74,'2016-01-25',1,8,10000,NULL,150,NULL,1,'2016-01-25 20:26:14',NULL,NULL),(75,'2016-01-25',1,8,NULL,2,NULL,200,1,'2016-01-25 20:26:58',NULL,NULL),(76,'2016-01-25',1,9,10000,NULL,25,NULL,1,'2016-01-25 20:58:49',NULL,NULL),(77,'2016-01-27',1,4,NULL,3,NULL,250,2,'2016-01-27 19:43:57',NULL,NULL);

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat` int(11) DEFAULT NULL,
  `cat_sub` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `is_rawmat` int(11) DEFAULT '0',
  `supplier_id` int(11) DEFAULT NULL,
  `pbrand` int(11) DEFAULT NULL,
  `pmodel` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `mfi` int(11) DEFAULT NULL,
  `product_type` int(11) DEFAULT NULL,
  `warn_qty` double DEFAULT NULL,
  `unit_convertable` int(11) DEFAULT '0',
  `vatable` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `items` */

insert  into `items`(`id`,`cat`,`cat_sub`,`code`,`name`,`desc`,`unit`,`is_rawmat`,`supplier_id`,`pbrand`,`pmodel`,`country`,`grade`,`mfi`,`product_type`,`warn_qty`,`unit_convertable`,`vatable`) values (1,1,2,'00001','Shirt One','BLUE (XL)','Pcs',0,1,1,1,NULL,1,1,NULL,NULL,0,0),(2,1,1,'00002','Shirt One','BLACK (XXL)','Pcs',0,1,1,1,NULL,1,1,NULL,NULL,0,0),(3,1,3,'00003','Shirt One','RED','Pcs',0,1,1,1,NULL,1,1,NULL,NULL,0,0),(4,3,3,'00004','Jeans','BLACK','Roll',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),(5,4,NULL,'00005','Fogg','BLACK','Pcs',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),(6,4,NULL,'00006','Fogg','RED','Pcs',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),(7,4,NULL,'00007','Axe','BLACK','Pcs',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),(8,2,3,'00008','T-Shirt','ROUND COLLER','Pcs',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),(9,5,4,'00009','Nazirshail','NA','KG',0,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),(10,6,5,'00010','Item One','(T)0.3MM X (W)1M X (L)1000M','Roll',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0);

/*Table structure for table `lookup` */

DROP TABLE IF EXISTS `lookup`;

CREATE TABLE `lookup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` int(10) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `type2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

/*Data for the table `lookup` */

insert  into `lookup`(`id`,`name`,`code`,`type`,`type2`) values (43,'ACTIVE',1,'is_active',NULL),(44,'INACTIVE',2,'is_active',NULL),(45,'VIRGIN',3,'product_type',NULL),(46,'RECYCLED',4,'product_type',NULL),(47,'SPOT PURCHASE',5,'order_sub_type','local'),(48,'QUATATION PURCHASE',6,'order_sub_type','local'),(49,'TENDER PURCHASE',7,'order_sub_type','local'),(50,'ETC',8,'order_sub_type','local'),(51,'LC under BOND',9,'order_sub_type','import'),(52,'LC under COMMERCIA',10,'order_sub_type','import'),(53,'LC under CAPITAL MACHINARY',11,'order_sub_type','import'),(54,'LC under SPARE PARTS',12,'order_sub_type','import'),(55,'LOCAL LC',13,'order_sub_type','import'),(56,'UNDER DIRECT PURCHASE',14,'order_sub_type','import'),(57,'PURCHASE under TT',15,'order_sub_type','import'),(60,'LOCAL',16,'order_type',NULL),(61,'IMPORT',17,'order_type',NULL),(62,'LOCAL',18,'order_type2',NULL),(63,'EXPORT',19,'order_type2',NULL),(64,'CASH',20,'received_type',NULL),(65,'CHEQUE',21,'received_type',NULL);

/*Table structure for table `machine_names` */

DROP TABLE IF EXISTS `machine_names`;

CREATE TABLE `machine_names` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `machine_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `machine_names` */

/*Table structure for table `machines` */

DROP TABLE IF EXISTS `machines`;

CREATE TABLE `machines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `machines` */

insert  into `machines`(`id`,`name`,`code`,`details`) values (1,'asfd','343','');

/*Table structure for table `master_lc` */

DROP TABLE IF EXISTS `master_lc`;

CREATE TABLE `master_lc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `lc_no` varchar(255) DEFAULT NULL,
  `lc_amount` double DEFAULT NULL,
  `shipment_from` varchar(255) DEFAULT NULL,
  `shipment_to` varchar(255) DEFAULT NULL,
  `shipment_date` date DEFAULT NULL,
  `hs_code` varchar(255) DEFAULT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `c_f_agent` varchar(255) DEFAULT NULL,
  `transport_agency` varchar(255) DEFAULT NULL,
  `last_date_of_shipment` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `lc_amended` varchar(255) DEFAULT NULL,
  `lc_date` date DEFAULT NULL,
  `lc_tenor_id` int(11) DEFAULT NULL,
  `export_lc_no` varchar(255) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `master_lc` */

/*Table structure for table `member_points` */

DROP TABLE IF EXISTS `member_points`;

CREATE TABLE `member_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `inv_no` varchar(255) DEFAULT NULL,
  `added_point` double DEFAULT NULL,
  `used_point` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `reduced_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_member_points` (`member_id`),
  CONSTRAINT `FK_member_points` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `member_points` */

insert  into `member_points`(`id`,`member_id`,`inv_no`,`added_point`,`used_point`,`date`,`remarks`,`added_by`,`reduced_by`) values (1,1,'201601271',15,NULL,'2016-01-27',NULL,NULL,NULL);

/*Table structure for table `member_points_conf` */

DROP TABLE IF EXISTS `member_points_conf`;

CREATE TABLE `member_points_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `point_add_after_amount` double DEFAULT NULL,
  `point_add` double DEFAULT NULL,
  `over_amount` double DEFAULT NULL,
  `each_point_amount` double DEFAULT NULL,
  `usable_after_point` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `member_points_conf` */

insert  into `member_points_conf`(`id`,`is_active`,`start_date`,`end_date`,`point_add_after_amount`,`point_add`,`over_amount`,`each_point_amount`,`usable_after_point`) values (1,1,'2016-01-25','2016-02-29',100,1,50,1,1000);

/*Table structure for table `members` */

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `spouse` varchar(255) DEFAULT NULL,
  `card_no` varchar(255) DEFAULT NULL,
  `available_point` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `members` */

insert  into `members`(`id`,`name`,`contact_no`,`email`,`address`,`dob`,`spouse`,`card_no`,`available_point`) values (1,'Tanim','01719062757','','','0000-00-00','','01719062757',15);

/*Table structure for table `mfis` */

DROP TABLE IF EXISTS `mfis`;

CREATE TABLE `mfis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mfis` */

insert  into `mfis`(`id`,`name`) values (1,'MFI One');

/*Table structure for table `p_brand` */

DROP TABLE IF EXISTS `p_brand`;

CREATE TABLE `p_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `p_brand` */

insert  into `p_brand`(`id`,`name`) values (1,'Brand One');

/*Table structure for table `p_model` */

DROP TABLE IF EXISTS `p_model`;

CREATE TABLE `p_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `p_model` */

insert  into `p_model`(`id`,`name`) values (1,'Model One');

/*Table structure for table `pos` */

DROP TABLE IF EXISTS `pos`;

CREATE TABLE `pos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_inv_no` int(11) DEFAULT NULL,
  `inv_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `price` double DEFAULT '0',
  `vatable_price` double DEFAULT NULL,
  `qty` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `overall_discount` double DEFAULT '0',
  `discount_type` int(11) DEFAULT NULL,
  `cash_payment` double DEFAULT '0',
  `visa_payment` double DEFAULT '0',
  `master_payment` double DEFAULT '0',
  `amex_payment` double DEFAULT '0',
  `gift_card_payment` double DEFAULT '0',
  `cash_return` double DEFAULT '0',
  `initiated_by` int(11) DEFAULT NULL,
  `authorized_by` int(11) DEFAULT NULL,
  `machine_id` int(11) DEFAULT NULL,
  `is_void` int(11) DEFAULT '0',
  `update_by` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_auth_by` int(11) DEFAULT NULL,
  `month` int(2) unsigned zerofill DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `void_auth_by` int(11) DEFAULT NULL,
  `void_time` datetime DEFAULT NULL,
  `is_recycled` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `pos` */

insert  into `pos`(`id`,`max_inv_no`,`inv_no`,`date`,`time`,`store_id`,`item_id`,`price`,`vatable_price`,`qty`,`discount`,`overall_discount`,`discount_type`,`cash_payment`,`visa_payment`,`master_payment`,`amex_payment`,`gift_card_payment`,`cash_return`,`initiated_by`,`authorized_by`,`machine_id`,`is_void`,`update_by`,`update_time`,`update_auth_by`,`month`,`year`,`void_auth_by`,`void_time`,`is_recycled`) values (1,1,'201601251','2016-01-25','20:24:55',1,4,250,250,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(2,1,'201601251','2016-01-25','20:24:55',1,7,100,100,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(3,1,'201601251','2016-01-25','20:24:55',1,5,100,100,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(4,1,'201601251','2016-01-25','20:24:55',1,6,100,100,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(5,1,'201601251','2016-01-25','20:24:56',1,2,150,150,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(6,1,'201601251','2016-01-25','20:24:56',1,1,160,160,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(7,1,'201601251','2016-01-25','20:24:56',1,3,100,100,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(8,1,'201601251','2016-01-25','20:24:56',1,8,200,200,1,0,2,1,1136.8,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(9,2,'201601252','2016-01-25','20:26:59',1,8,200,200,2,0,20,0,380,0,0,0,0,0,1,NULL,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0),(10,1,'201601271','2016-01-27','19:43:57',1,4,250,250,3,0,0,0,750,0,0,0,0,0,2,1,NULL,0,NULL,NULL,NULL,01,2016,NULL,NULL,0);

/*Table structure for table `production_input` */

DROP TABLE IF EXISTS `production_input`;

CREATE TABLE `production_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `machine` int(11) DEFAULT NULL,
  `track_no` varchar(255) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `qty` double DEFAULT '0',
  `qty_kg` double DEFAULT '0',
  `return_qty` double DEFAULT '0',
  `return_qty_kg` double DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `production_input` */

insert  into `production_input`(`id`,`max_sl_no`,`sl_no`,`date`,`time`,`store`,`machine`,`track_no`,`item`,`qty`,`qty_kg`,`return_qty`,`return_qty_kg`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (1,1,'343-201601241','2016-01-24','14:09:00',1,1,'',4,1,NULL,0,0,1,'2016-01-24 14:09:40',NULL,NULL);

/*Table structure for table `production_output` */

DROP TABLE IF EXISTS `production_output`;

CREATE TABLE `production_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `production_input_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `qty_kg` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_production_output` (`production_input_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `production_output` */

/*Table structure for table `production_wastage` */

DROP TABLE IF EXISTS `production_wastage`;

CREATE TABLE `production_wastage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `production_input_no` varchar(255) DEFAULT NULL,
  `wastage_qty` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `production_wastage` */

/*Table structure for table `purchase_order` */

DROP TABLE IF EXISTS `purchase_order`;

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sl_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `ref_no` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `procurement_id` int(11) DEFAULT NULL,
  `procurement_no` varchar(255) DEFAULT NULL,
  `order_qty` double DEFAULT NULL,
  `subj` varchar(255) DEFAULT NULL,
  `is_verified` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_order` (`procurement_id`),
  CONSTRAINT `FK_purchase_order` FOREIGN KEY (`procurement_id`) REFERENCES `purchase_procurement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `purchase_order` */

insert  into `purchase_order`(`id`,`sl_no`,`max_sl_no`,`ref_no`,`issue_date`,`procurement_id`,`procurement_no`,`order_qty`,`subj`,`is_verified`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (1,'201601211',1,'','2016-01-21',1,'201601211',100000,'',1,1,'2016-01-21 04:57:09',NULL,NULL),(2,'201601211',1,'','2016-01-21',2,'201601211',100000,'',1,1,'2016-01-21 04:57:09',NULL,NULL);

/*Table structure for table `purchase_procurement` */

DROP TABLE IF EXISTS `purchase_procurement`;

CREATE TABLE `purchase_procurement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `req_id` int(11) DEFAULT NULL,
  `req_no` varchar(255) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `order_type` int(11) DEFAULT NULL,
  `order_sub_type` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_procurement` (`req_no`),
  KEY `FK_purchase_procurement1` (`req_id`),
  CONSTRAINT `FK_purchase_procurement1` FOREIGN KEY (`req_id`) REFERENCES `purchase_requisition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `purchase_procurement` */

insert  into `purchase_procurement`(`id`,`req_id`,`req_no`,`sl_no`,`max_sl_no`,`date`,`store`,`item`,`supplier_id`,`order_type`,`order_sub_type`,`department`,`qty`,`cost`,`remarks`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (1,1,'201601211','201601211',1,'2016-01-21',1,1,1,16,5,1,100000,550,'',1,'2016-01-21 04:56:52',NULL,NULL),(2,2,'201601211','201601211',1,'2016-01-21',1,2,1,16,5,1,100000,550,'',1,'2016-01-21 04:56:52',NULL,NULL);

/*Table structure for table `purchase_rcv_rtn` */

DROP TABLE IF EXISTS `purchase_rcv_rtn`;

CREATE TABLE `purchase_rcv_rtn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challan_no` varchar(255) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `rcv_date` date DEFAULT NULL,
  `rcv_qty` double DEFAULT NULL,
  `rtn_date` date DEFAULT NULL,
  `rtn_qty` double DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `remarks_for_rcv` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `return_by` int(11) DEFAULT NULL,
  `return_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_rcv_rtn` (`po_id`),
  CONSTRAINT `FK_purchase_rcv_rtn` FOREIGN KEY (`po_id`) REFERENCES `purchase_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `purchase_rcv_rtn` */

insert  into `purchase_rcv_rtn`(`id`,`challan_no`,`po_id`,`supplier_id`,`rcv_date`,`rcv_qty`,`rtn_date`,`rtn_qty`,`cost`,`remarks_for_rcv`,`remarks`,`created_by`,`created_time`,`updated_by`,`updated_time`,`return_by`,`return_time`) values (3,'112233',1,1,'2016-01-23',100000,NULL,NULL,550,'',NULL,1,'2016-01-23 22:30:18',NULL,NULL,NULL,NULL),(4,'112233',2,1,'2016-01-23',100000,NULL,NULL,550,'',NULL,1,'2016-01-23 22:30:18',NULL,NULL,NULL,NULL);

/*Table structure for table `purchase_requisition` */

DROP TABLE IF EXISTS `purchase_requisition`;

CREATE TABLE `purchase_requisition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sl_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `is_pp_created` int(11) DEFAULT '0',
  `is_po_created` int(11) DEFAULT '0',
  `store_req_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `purchase_requisition` */

insert  into `purchase_requisition`(`id`,`sl_no`,`max_sl_no`,`date`,`store`,`item`,`department`,`qty`,`cost`,`remarks`,`created_by`,`created_time`,`updated_by`,`updated_time`,`is_pp_created`,`is_po_created`,`store_req_id`) values (1,'201601211',1,'2016-01-21',1,1,1,100000,550,'',1,'2016-01-21 04:56:29',NULL,NULL,1,0,NULL),(2,'201601211',1,'2016-01-21',1,2,1,100000,550,'',1,'2016-01-21 04:56:29',NULL,NULL,1,0,NULL),(3,'201601211',1,'2016-01-21',1,3,1,100000,550,'',1,'2016-01-21 04:56:29',NULL,NULL,0,0,NULL),(4,'201601251',1,'2016-01-25',1,2,1,6,50,'',1,'2016-01-25 20:51:01',NULL,NULL,0,0,NULL);

/*Table structure for table `Rights` */

DROP TABLE IF EXISTS `Rights`;

CREATE TABLE `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`),
  CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `Rights` */

/*Table structure for table `sale_order` */

DROP TABLE IF EXISTS `sale_order`;

CREATE TABLE `sale_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sl_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expected_d_date` date DEFAULT NULL,
  `subj` varchar(255) DEFAULT NULL,
  `order_type2` int(11) DEFAULT NULL,
  `pi_no` varchar(255) DEFAULT NULL,
  `pi_date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `contact_person` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `conv_unit` int(11) DEFAULT NULL,
  `sales_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `is_stopped` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Data for the table `sale_order` */

insert  into `sale_order`(`id`,`sl_no`,`max_sl_no`,`issue_date`,`expected_d_date`,`subj`,`order_type2`,`pi_no`,`pi_date`,`store`,`customer_id`,`contact_person`,`item`,`qty`,`price`,`conv_unit`,`sales_by`,`created_by`,`created_time`,`updated_by`,`updated_time`,`is_stopped`) values (10,'201601231',1,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,2,2,500,NULL,1,1,'2016-01-23 21:32:48',NULL,NULL,1),(11,'201601231',1,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,1,2,500,NULL,1,1,'2016-01-23 21:32:48',NULL,NULL,1),(12,'201601232',2,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,2,10,100,NULL,1,1,'2016-01-23 21:40:12',NULL,NULL,1),(13,'201601233',3,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,1,15,200,NULL,1,1,'2016-01-23 21:41:32',NULL,NULL,1),(14,'201601234',4,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,4,10,250,3,1,1,'2016-01-23 23:22:55',NULL,NULL,1),(15,'201601235',5,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,3,10,100,3,1,1,'2016-01-23 23:38:17',NULL,NULL,1),(16,'201601236',6,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,2,1,150,NULL,1,1,'2016-01-23 23:42:24',NULL,NULL,1),(17,'201601237',7,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,1,3,160,NULL,1,1,'2016-01-23 23:53:14',NULL,NULL,0),(18,'201601237',7,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,3,3,100,3,1,1,'2016-01-23 23:53:14',NULL,NULL,0),(19,'201601237',7,'2016-01-23','2016-01-23','',18,'','0000-00-00',1,1,1,2,3,150,NULL,1,1,'2016-01-23 23:53:14',NULL,NULL,0),(20,'201601241',1,'2016-01-24','2016-01-24','',18,'','0000-00-00',1,1,1,4,10,250,3,1,1,'2016-01-24 00:06:24',NULL,NULL,0),(21,'201601242',2,'2016-01-24','2016-01-24','',18,'','0000-00-00',1,1,1,2,6,150,NULL,1,1,'2016-01-24 01:02:57',NULL,NULL,0),(22,'201601243',3,'2016-01-24','2016-01-24','',18,'','0000-00-00',1,1,1,4,10,250,1,1,1,'2016-01-24 01:11:38',NULL,NULL,0),(23,'201601244',4,'2016-01-24','2016-01-24','',18,'','0000-00-00',1,1,1,3,10,100,3,1,1,'2016-01-24 11:19:46',NULL,NULL,0),(24,'201601244',4,'2016-01-24','2016-01-24','',18,'','0000-00-00',1,1,1,4,10,250,1,1,1,'2016-01-24 11:19:46',NULL,NULL,1),(25,'201601251',1,'2016-01-25','2016-01-26','',18,'','0000-00-00',1,1,1,9,1,35,NULL,1,1,'2016-01-25 21:01:07',NULL,NULL,0),(26,'201601252',2,'2016-01-25','2016-01-25','',18,'','0000-00-00',1,1,1,4,2,250,NULL,1,1,'2016-01-25 21:46:53',NULL,NULL,0),(27,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,4,300,250,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(28,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,7,300,100,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(29,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,5,300,100,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(30,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,6,300,100,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(31,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,9,300,100,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(32,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,2,300,150,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(33,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,1,300,160,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(34,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,3,300,100,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0),(35,'201601261',1,'2016-01-26','2016-01-26','',18,'','0000-00-00',1,1,NULL,8,300,200,NULL,1,1,'2016-01-26 01:19:43',NULL,NULL,0);

/*Table structure for table `sell_delv_rtn` */

DROP TABLE IF EXISTS `sell_delv_rtn`;

CREATE TABLE `sell_delv_rtn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill` int(11) DEFAULT '0',
  `sl_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `so_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(255) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `so_no` varchar(255) DEFAULT NULL,
  `d_date` date DEFAULT NULL,
  `d_qty` double DEFAULT NULL,
  `r_date` date DEFAULT NULL,
  `r_qty` double DEFAULT NULL,
  `remarks1` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `d_qty_kg` double DEFAULT NULL,
  `r_qty_kg` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `return_by` int(11) DEFAULT NULL,
  `return_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sell_delv_rtn` (`so_id`),
  CONSTRAINT `FK_sell_delv_rtn` FOREIGN KEY (`so_id`) REFERENCES `sale_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

/*Data for the table `sell_delv_rtn` */

insert  into `sell_delv_rtn`(`id`,`bill`,`sl_no`,`max_sl_no`,`so_id`,`customer_id`,`vehicle_type`,`vehicle_no`,`item`,`store`,`so_no`,`d_date`,`d_qty`,`r_date`,`r_qty`,`remarks1`,`remarks`,`d_qty_kg`,`r_qty_kg`,`created_by`,`created_time`,`updated_by`,`updated_time`,`return_by`,`return_time`) values (38,1,'201601241',1,22,1,'','',4,1,'201601243','2016-01-24',10,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 01:17:44',NULL,NULL,NULL,NULL),(39,1,'201601242',2,21,1,'','',2,1,'201601242','2016-01-24',6,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 01:17:56',NULL,NULL,NULL,NULL),(40,1,'201601243',3,20,1,'','',4,1,'201601241','2016-01-24',10,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 01:18:08',NULL,NULL,NULL,NULL),(41,1,'201601244',4,17,1,'','',1,1,'201601237','2016-01-24',3,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 01:18:25',NULL,NULL,NULL,NULL),(42,1,'201601244',4,18,1,'','',3,1,'201601237','2016-01-24',3,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 01:18:25',NULL,NULL,NULL,NULL),(43,1,'201601244',4,19,1,'','',2,1,'201601237','2016-01-24',3,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 01:18:25',NULL,NULL,NULL,NULL),(44,1,'201601245',5,23,1,'','',3,1,'201601244','2016-01-24',5,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 11:20:28',NULL,NULL,NULL,NULL),(45,1,'201601246',6,23,1,'','',3,1,'201601244','2016-01-24',5,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 11:20:39',NULL,NULL,NULL,NULL),(46,1,'201601247',7,24,1,'','',4,1,'201601244','2016-01-24',5,NULL,NULL,'',NULL,NULL,NULL,1,'2016-01-24 11:20:52',NULL,NULL,NULL,NULL);

/*Table structure for table `selling_price` */

DROP TABLE IF EXISTS `selling_price`;

CREATE TABLE `selling_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_selling_price` (`item`),
  CONSTRAINT `FK_selling_price` FOREIGN KEY (`item`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `selling_price` */

insert  into `selling_price`(`id`,`item`,`price`,`date`,`is_active`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (1,2,150,'2016-01-21',1,1,'2016-01-21 22:28:26',NULL,NULL),(2,1,160,'2016-01-21',1,1,'2016-01-21 22:28:35',NULL,NULL),(3,3,100,'2016-01-21',1,1,'2016-01-21 22:28:46',NULL,NULL),(4,4,250,'2016-01-21',1,1,'2016-01-21 22:28:55',NULL,NULL),(5,7,100,'2016-01-25',1,1,'2016-01-25 20:22:11',NULL,NULL),(6,6,100,'2016-01-25',1,1,'2016-01-25 20:22:20',NULL,NULL),(7,5,100,'2016-01-25',1,1,'2016-01-25 20:22:31',NULL,NULL),(8,8,200,'2016-01-25',1,1,'2016-01-25 20:24:14',NULL,NULL);

/*Table structure for table `stock_transfer_history` */

DROP TABLE IF EXISTS `stock_transfer_history`;

CREATE TABLE `stock_transfer_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_store` int(11) DEFAULT NULL,
  `to_store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `send_qty` double DEFAULT NULL,
  `rcv_qty` double DEFAULT '0',
  `send_date` date DEFAULT NULL,
  `rcv_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `rcv_by` int(11) DEFAULT NULL,
  `rcv_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `stock_transfer_history` */

/*Table structure for table `storck_tranfer_history_from_temp_to_main` */

DROP TABLE IF EXISTS `storck_tranfer_history_from_temp_to_main`;

CREATE TABLE `storck_tranfer_history_from_temp_to_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `from_temp_store` int(11) DEFAULT NULL,
  `to_main_store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `storck_tranfer_history_from_temp_to_main` */

/*Table structure for table `store_inventory` */

DROP TABLE IF EXISTS `store_inventory`;

CREATE TABLE `store_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `stock_in` double DEFAULT NULL,
  `stock_out` double DEFAULT NULL,
  `costing_price` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `store_inventory` */

insert  into `store_inventory`(`id`,`date`,`store`,`item`,`stock_in`,`stock_out`,`costing_price`) values (1,'2016-01-24',1,4,1,NULL,0),(2,'2016-01-24',1,4,NULL,1,NULL);

/*Table structure for table `store_req_d_r` */

DROP TABLE IF EXISTS `store_req_d_r`;

CREATE TABLE `store_req_d_r` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `req_no` varchar(255) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL,
  `d_qty` double DEFAULT NULL,
  `d_date` date DEFAULT NULL,
  `r_qty` double DEFAULT NULL,
  `r_date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `return_by` int(11) DEFAULT NULL,
  `return_time` datetime DEFAULT NULL,
  `is_approved` int(11) DEFAULT '0',
  `approved_by` int(11) DEFAULT NULL,
  `approved_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_store_req_d_r` (`req_id`),
  CONSTRAINT `FK_store_req_d_r` FOREIGN KEY (`req_id`) REFERENCES `store_requisition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `store_req_d_r` */

/*Table structure for table `store_requisition` */

DROP TABLE IF EXISTS `store_requisition`;

CREATE TABLE `store_requisition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sl_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `from_store` int(11) DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `req_date` date DEFAULT NULL,
  `req_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `store_requisition` */

/*Table structure for table `stores` */

DROP TABLE IF EXISTS `stores`;

CREATE TABLE `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `stores` */

insert  into `stores`(`id`,`store_name`,`location`) values (1,'Store One','');

/*Table structure for table `supplier_contact_persons` */

DROP TABLE IF EXISTS `supplier_contact_persons`;

CREATE TABLE `supplier_contact_persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `contact_number1` varchar(20) DEFAULT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `contact_number3` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_supplier_contact_persons` (`company_id`),
  CONSTRAINT `FK_supplier_contact_persons` FOREIGN KEY (`company_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `supplier_contact_persons` */

/*Table structure for table `supplier_mr` */

DROP TABLE IF EXISTS `supplier_mr`;

CREATE TABLE `supplier_mr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `received_type` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `discount` double DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `supplier_mr` */

insert  into `supplier_mr`(`id`,`max_sl_no`,`sl_no`,`supplier_id`,`date`,`narration`,`received_type`,`bank_id`,`cheque_no`,`cheque_date`,`paid_amount`,`discount`,`created_by`,`created_time`,`updated_by`,`updated_time`) values (5,1,'201601231',1,'2016-01-23','',20,NULL,'','0000-00-00',100000000,0,1,'2016-01-23 22:31:03',NULL,NULL);

/*Table structure for table `suppliers` */

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_no` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text,
  `company_contact_no` varchar(20) DEFAULT NULL,
  `company_fax` varchar(20) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_web` varchar(50) DEFAULT NULL,
  `opening_amount` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `suppliers` */

insert  into `suppliers`(`id`,`id_no`,`company_name`,`company_address`,`company_contact_no`,`company_fax`,`company_email`,`company_web`,`opening_amount`) values (1,'20160120110154','Supplier One','','','','','',0),(2,'20160125030102','Feku','','','','','',0);

/*Table structure for table `tenors` */

DROP TABLE IF EXISTS `tenors`;

CREATE TABLE `tenors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tenors` */

insert  into `tenors`(`id`,`title`) values (1,'30'),(2,'60'),(3,'120');

/*Table structure for table `user_store` */

DROP TABLE IF EXISTS `user_store`;

CREATE TABLE `user_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_store` (`user_id`),
  CONSTRAINT `FK_user_store` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user_store` */

insert  into `user_store`(`id`,`user_id`,`store_id`,`is_active`) values (1,2,1,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_password` varchar(255) DEFAULT NULL,
  `is_pos_user` int(11) DEFAULT '0',
  `is_authorizer` int(11) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `real_pin_code` varchar(255) DEFAULT NULL,
  `create_by` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_by` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`employee_id`,`username`,`password`,`real_password`,`is_pos_user`,`is_authorizer`,`pin_code`,`real_pin_code`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,1,'superadmin','17c4520f6cfd1ab53d8745e84681eb49','superadmin',0,1,'81dc9bdb52d04dc20036dbd8313ed055','1234',NULL,NULL,'superadmin','2016-01-27 19:41:00'),(2,2,'tanim123','12f3315cf1ba3c9164ecceea3bbf3a86','tanim123',1,0,'d41d8cd98f00b204e9800998ecf8427e','','superadmin','2016-01-27 19:40:13',NULL,NULL);

/*Table structure for table `your_company` */

DROP TABLE IF EXISTS `your_company`;

CREATE TABLE `your_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `vat_regi_no` varchar(255) DEFAULT NULL,
  `vat_amount` double DEFAULT NULL,
  `is_active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `your_company` */

insert  into `your_company`(`id`,`company_name`,`location`,`contact`,`email`,`web`,`vat_regi_no`,`vat_amount`,`is_active`) values (2,'Grow Biz Industries Limited','Deshipara, Joydebpur, Gazipur','+880258950093','info@polycellbd.com','http://www.polycellbd.com','Pending',4,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
