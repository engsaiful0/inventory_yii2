-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2016 at 02:27 AM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dresswes_inv`
--

-- --------------------------------------------------------

--
-- Table structure for table `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('POS User', '2', NULL, 'N;'),
('SuperAdmin', '1', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Banks.*', 1, NULL, NULL, 'N;'),
('Banks.Admin', 0, NULL, NULL, 'N;'),
('Banks.Create', 0, NULL, NULL, 'N;'),
('Banks.CreateBankFromOutSide', 0, NULL, NULL, 'N;'),
('Banks.Delete', 0, NULL, NULL, 'N;'),
('Banks.Update', 0, NULL, NULL, 'N;'),
('Cats.*', 1, NULL, NULL, 'N;'),
('Cats.Admin', 0, NULL, NULL, 'N;'),
('Cats.Create', 0, NULL, NULL, 'N;'),
('Cats.CreateCatFromOutSide', 0, NULL, NULL, 'N;'),
('Cats.Delete', 0, NULL, NULL, 'N;'),
('Cats.Update', 0, NULL, NULL, 'N;'),
('CatsSub.*', 1, NULL, NULL, 'N;'),
('CatsSub.Admin', 0, NULL, NULL, 'N;'),
('CatsSub.Create', 0, NULL, NULL, 'N;'),
('CatsSub.CreateCatSubFromOutSide', 0, NULL, NULL, 'N;'),
('CatsSub.Delete', 0, NULL, NULL, 'N;'),
('CatsSub.Update', 0, NULL, NULL, 'N;'),
('CostingPrice.*', 1, NULL, NULL, 'N;'),
('CostingPrice.AddCostingPrice', 0, NULL, NULL, 'N;'),
('CostingPrice.Admin', 0, NULL, NULL, 'N;'),
('CostingPrice.Delete', 0, NULL, NULL, 'N;'),
('CostingPrice.PriceHistory', 0, NULL, NULL, 'N;'),
('CostingPrice.Update', 0, NULL, NULL, 'N;'),
('Countries.*', 1, NULL, NULL, 'N;'),
('Countries.Admin', 0, NULL, NULL, 'N;'),
('Countries.Create', 0, NULL, NULL, 'N;'),
('Countries.CreateCountryFromOutSide', 0, NULL, NULL, 'N;'),
('Countries.Delete', 0, NULL, NULL, 'N;'),
('Countries.Update', 0, NULL, NULL, 'N;'),
('CreditMemo.*', 1, NULL, NULL, 'N;'),
('CreditMemo.Admin', 0, NULL, NULL, 'N;'),
('CreditMemo.Create', 0, NULL, NULL, 'N;'),
('CreditMemo.Delete', 0, NULL, NULL, 'N;'),
('CreditMemo.DeleteAll', 0, NULL, NULL, 'N;'),
('CreditMemo.Update', 0, NULL, NULL, 'N;'),
('CreditMemo.VoucherPreview', 0, NULL, NULL, 'N;'),
('CustomerBill.*', 1, NULL, NULL, 'N;'),
('CustomerBill.Admin', 0, NULL, NULL, 'N;'),
('CustomerBill.AdminCreditMemo', 0, NULL, NULL, 'N;'),
('CustomerBill.BillCreate', 0, NULL, NULL, 'N;'),
('CustomerBill.BillCreateView', 0, NULL, NULL, 'N;'),
('CustomerBill.BillPreview', 0, NULL, NULL, 'N;'),
('CustomerBill.Create', 0, NULL, NULL, 'N;'),
('CustomerBill.Delete', 0, NULL, NULL, 'N;'),
('CustomerBill.DeleteAll', 0, NULL, NULL, 'N;'),
('CustomerContactPersons.*', 1, NULL, NULL, 'N;'),
('CustomerContactPersons.AddContactPerson', 0, NULL, NULL, 'N;'),
('CustomerContactPersons.Admin', 0, NULL, NULL, 'N;'),
('CustomerContactPersons.ContactPersonsOfThis', 0, NULL, NULL, 'N;'),
('CustomerContactPersons.Contacts', 0, NULL, NULL, 'N;'),
('CustomerContactPersons.Create', 0, NULL, NULL, 'N;'),
('CustomerContactPersons.Delete', 0, NULL, NULL, 'N;'),
('CustomerContactPersons.Update', 0, NULL, NULL, 'N;'),
('CustomerMr.*', 1, NULL, NULL, 'N;'),
('CustomerMr.AddMoneyReceipt', 0, NULL, NULL, 'N;'),
('CustomerMr.Admin', 0, NULL, NULL, 'N;'),
('CustomerMr.Delete', 0, NULL, NULL, 'N;'),
('CustomerMr.DeleteAll', 0, NULL, NULL, 'N;'),
('CustomerMr.MoneyReceiptHistory', 0, NULL, NULL, 'N;'),
('CustomerMr.MrPreview', 0, NULL, NULL, 'N;'),
('CustomerMr.Update', 0, NULL, NULL, 'N;'),
('Customers.*', 1, NULL, NULL, 'N;'),
('Customers.Admin', 0, NULL, NULL, 'N;'),
('Customers.AdminMoneyReceipt', 0, NULL, NULL, 'N;'),
('Customers.Create', 0, NULL, NULL, 'N;'),
('Customers.CreateCustomerFromOutSide', 0, NULL, NULL, 'N;'),
('Customers.CustomerLedgerAll', 0, NULL, NULL, 'N;'),
('Customers.CustomerLedgerAllView', 0, NULL, NULL, 'N;'),
('Customers.CustomerLedgerSpecific', 0, NULL, NULL, 'N;'),
('Customers.CustomerLedgerSpecificView', 0, NULL, NULL, 'N;'),
('Customers.Delete', 0, NULL, NULL, 'N;'),
('Customers.Update', 0, NULL, NULL, 'N;'),
('Customers.View', 0, NULL, NULL, 'N;'),
('DashBoardReport.*', 1, NULL, NULL, 'N;'),
('DashBoardReport.LiabilitiesGraphPreview', 0, NULL, NULL, 'N;'),
('DashBoardReport.LiabilitiesPreview', 0, NULL, NULL, 'N;'),
('DashBoardReport.PurchasePreview', 0, NULL, NULL, 'N;'),
('DashBoardReport.SalesPreview', 0, NULL, NULL, 'N;'),
('Departments.*', 1, NULL, NULL, 'N;'),
('Departments.Admin', 0, NULL, NULL, 'N;'),
('Departments.Create', 0, NULL, NULL, 'N;'),
('Departments.CreateDepartmentFromOutSide', 0, NULL, NULL, 'N;'),
('Departments.Delete', 0, NULL, NULL, 'N;'),
('Departments.Update', 0, NULL, NULL, 'N;'),
('Designations.*', 1, NULL, NULL, 'N;'),
('Designations.Admin', 0, NULL, NULL, 'N;'),
('Designations.Create', 0, NULL, NULL, 'N;'),
('Designations.CreateMain', 0, NULL, NULL, 'N;'),
('Designations.Delete', 0, NULL, NULL, 'N;'),
('Designations.Update', 0, NULL, NULL, 'N;'),
('Employees.*', 1, NULL, NULL, 'N;'),
('Employees.Admin', 0, NULL, NULL, 'N;'),
('Employees.Create', 0, NULL, NULL, 'N;'),
('Employees.CreateEmployeeFromOutSide', 0, NULL, NULL, 'N;'),
('Employees.Delete', 0, NULL, NULL, 'N;'),
('Employees.Update', 0, NULL, NULL, 'N;'),
('Employees.View', 0, NULL, NULL, 'N;'),
('Grades.*', 1, NULL, NULL, 'N;'),
('Grades.Admin', 0, NULL, NULL, 'N;'),
('Grades.Create', 0, NULL, NULL, 'N;'),
('Grades.CreateGradesFromOutSide', 0, NULL, NULL, 'N;'),
('Grades.Delete', 0, NULL, NULL, 'N;'),
('Grades.Update', 0, NULL, NULL, 'N;'),
('ImportDocument.*', 1, NULL, NULL, 'N;'),
('ImportDocument.Admin', 0, NULL, NULL, 'N;'),
('ImportDocument.Create', 0, NULL, NULL, 'N;'),
('ImportDocument.Delete', 0, NULL, NULL, 'N;'),
('ImportDocument.Update', 0, NULL, NULL, 'N;'),
('ImportDocument.View', 0, NULL, NULL, 'N;'),
('Inventory.*', 1, NULL, NULL, 'N;'),
('Inventory.Admin', 0, NULL, NULL, 'N;'),
('Inventory.Create', 0, NULL, NULL, 'N;'),
('Inventory.Delete', 0, NULL, NULL, 'N;'),
('Inventory.DeleteAll', 0, NULL, NULL, 'N;'),
('Inventory.StockReport', 0, NULL, NULL, 'N;'),
('Inventory.StockReportView', 0, NULL, NULL, 'N;'),
('Inventory.TransferStock', 0, NULL, NULL, 'N;'),
('Inventory.TransferStockCreate', 0, NULL, NULL, 'N;'),
('Inventory.TransferStockView', 0, NULL, NULL, 'N;'),
('Inventory.Update', 0, NULL, NULL, 'N;'),
('Items.*', 1, NULL, NULL, 'N;'),
('Items.Admin', 0, NULL, NULL, 'N;'),
('Items.AdminAddCostingPrice', 0, NULL, NULL, 'N;'),
('Items.AdminAddSellingPrice', 0, NULL, NULL, 'N;'),
('Items.BarCodeGen', 0, NULL, NULL, 'N;'),
('Items.Create', 0, NULL, NULL, 'N;'),
('Items.CreateItemFromOutSide', 0, NULL, NULL, 'N;'),
('Items.Delete', 0, NULL, NULL, 'N;'),
('Items.DeleteAll', 0, NULL, NULL, 'N;'),
('Items.ItemsOfThis', 0, NULL, NULL, 'N;'),
('Items.ItemsOfThisCat', 0, NULL, NULL, 'N;'),
('Items.ItemsOfThisSupplier', 0, NULL, NULL, 'N;'),
('Items.SetAsRawMat', 0, NULL, NULL, 'N;'),
('Items.SetUnitConvertable', 0, NULL, NULL, 'N;'),
('Items.SetVatable', 0, NULL, NULL, 'N;'),
('Items.UndoAsRawMat', 0, NULL, NULL, 'N;'),
('Items.UndoUnitConvertable', 0, NULL, NULL, 'N;'),
('Items.UndoVatable', 0, NULL, NULL, 'N;'),
('Items.Update', 0, NULL, NULL, 'N;'),
('MachineNames.*', 1, NULL, NULL, 'N;'),
('MachineNames.Admin', 0, NULL, NULL, 'N;'),
('MachineNames.Create', 0, NULL, NULL, 'N;'),
('MachineNames.Delete', 0, NULL, NULL, 'N;'),
('MachineNames.Update', 0, NULL, NULL, 'N;'),
('Machines.*', 1, NULL, NULL, 'N;'),
('Machines.Admin', 0, NULL, NULL, 'N;'),
('Machines.Create', 0, NULL, NULL, 'N;'),
('Machines.Delete', 0, NULL, NULL, 'N;'),
('Machines.Update', 0, NULL, NULL, 'N;'),
('MasterLc.*', 1, NULL, NULL, 'N;'),
('MasterLc.Admin', 0, NULL, NULL, 'N;'),
('MasterLc.Create', 0, NULL, NULL, 'N;'),
('MasterLc.Delete', 0, NULL, NULL, 'N;'),
('MasterLc.DetailsOfThisLc', 0, NULL, NULL, 'N;'),
('MasterLc.Update', 0, NULL, NULL, 'N;'),
('MasterLc.VerifiedImportPurchaseOrder', 0, NULL, NULL, 'N;'),
('MasterLc.View', 0, NULL, NULL, 'N;'),
('MemberPointsConf.*', 1, NULL, NULL, 'N;'),
('MemberPointsConf.Admin', 0, NULL, NULL, 'N;'),
('MemberPointsConf.Create', 0, NULL, NULL, 'N;'),
('MemberPointsConf.Delete', 0, NULL, NULL, 'N;'),
('MemberPointsConf.Update', 0, NULL, NULL, 'N;'),
('Members.*', 1, NULL, NULL, 'N;'),
('Members.AddPoints', 0, NULL, NULL, 'N;'),
('Members.Admin', 0, NULL, NULL, 'N;'),
('Members.AvailablePointsOfThis', 0, NULL, NULL, 'N;'),
('Members.Create', 0, NULL, NULL, 'N;'),
('Members.CreateMembersFromOutSide', 0, NULL, NULL, 'N;'),
('Members.Delete', 0, NULL, NULL, 'N;'),
('Members.MembersAVpoint', 0, NULL, NULL, 'N;'),
('Members.PointsHistory', 0, NULL, NULL, 'N;'),
('Members.ReducePoints', 0, NULL, NULL, 'N;'),
('Members.Update', 0, NULL, NULL, 'N;'),
('Mfis.*', 1, NULL, NULL, 'N;'),
('Mfis.Admin', 0, NULL, NULL, 'N;'),
('Mfis.Create', 0, NULL, NULL, 'N;'),
('Mfis.CreateMfisFromOutSide', 0, NULL, NULL, 'N;'),
('Mfis.Delete', 0, NULL, NULL, 'N;'),
('Mfis.Update', 0, NULL, NULL, 'N;'),
('PBrand.*', 1, NULL, NULL, 'N;'),
('PBrand.Admin', 0, NULL, NULL, 'N;'),
('PBrand.Create', 0, NULL, NULL, 'N;'),
('PBrand.CreatePBrandFromOutSide', 0, NULL, NULL, 'N;'),
('PBrand.Delete', 0, NULL, NULL, 'N;'),
('PBrand.Update', 0, NULL, NULL, 'N;'),
('PModel.*', 1, NULL, NULL, 'N;'),
('PModel.Admin', 0, NULL, NULL, 'N;'),
('PModel.Create', 0, NULL, NULL, 'N;'),
('PModel.CreatePModelFromOutSide', 0, NULL, NULL, 'N;'),
('PModel.Delete', 0, NULL, NULL, 'N;'),
('PModel.Update', 0, NULL, NULL, 'N;'),
('POS User', 2, 'POS User', NULL, 'N;'),
('Pos.*', 1, NULL, NULL, 'N;'),
('Pos.Admin', 0, NULL, NULL, 'N;'),
('Pos.AdminRecycled', 0, NULL, NULL, 'N;'),
('Pos.AuthorizationCheck', 0, NULL, NULL, 'N;'),
('Pos.AuthorizationCheckReprint', 0, NULL, NULL, 'N;'),
('Pos.AuthorizationCheckUpdate', 0, NULL, NULL, 'N;'),
('Pos.AuthorizationCheckVoid', 0, NULL, NULL, 'N;'),
('Pos.Create', 0, NULL, NULL, 'N;'),
('Pos.DeletePermanently', 0, NULL, NULL, 'N;'),
('Pos.PosReport', 0, NULL, NULL, 'N;'),
('Pos.PosReportView', 0, NULL, NULL, 'N;'),
('Pos.Reprint', 0, NULL, NULL, 'N;'),
('Pos.SoReportOfThis', 0, NULL, NULL, 'N;'),
('Pos.SoReportOfThisNonPosUser', 0, NULL, NULL, 'N;'),
('Pos.TempDelete', 0, NULL, NULL, 'N;'),
('Pos.TempDeleteUndo', 0, NULL, NULL, 'N;'),
('Pos.UpdateFromPos', 0, NULL, NULL, 'N;'),
('Pos.Void', 0, NULL, NULL, 'N;'),
('Pos.VoidPos', 0, NULL, NULL, 'N;'),
('Pos.VoidPosUndo', 0, NULL, NULL, 'N;'),
('Pos.VoidUpdate', 0, NULL, NULL, 'N;'),
('ProductionInput.*', 1, NULL, NULL, 'N;'),
('ProductionInput.Admin', 0, NULL, NULL, 'N;'),
('ProductionInput.AdminOutput', 0, NULL, NULL, 'N;'),
('ProductionInput.AdminReturn', 0, NULL, NULL, 'N;'),
('ProductionInput.AdminWastage', 0, NULL, NULL, 'N;'),
('ProductionInput.ConsumptionReport', 0, NULL, NULL, 'N;'),
('ProductionInput.ConsumptionReportView', 0, NULL, NULL, 'N;'),
('ProductionInput.Create', 0, NULL, NULL, 'N;'),
('ProductionInput.Delete', 0, NULL, NULL, 'N;'),
('ProductionInput.DeleteAll', 0, NULL, NULL, 'N;'),
('ProductionInput.DeleteFromUpdate', 0, NULL, NULL, 'N;'),
('ProductionInput.ReturnQty', 0, NULL, NULL, 'N;'),
('ProductionInput.Update', 0, NULL, NULL, 'N;'),
('ProductionOutput.*', 1, NULL, NULL, 'N;'),
('ProductionOutput.Admin', 0, NULL, NULL, 'N;'),
('ProductionOutput.Create', 0, NULL, NULL, 'N;'),
('ProductionOutput.Delete', 0, NULL, NULL, 'N;'),
('ProductionOutput.DeleteAll', 0, NULL, NULL, 'N;'),
('ProductionOutput.ProductionReport', 0, NULL, NULL, 'N;'),
('ProductionOutput.ProductionReportView', 0, NULL, NULL, 'N;'),
('ProductionOutput.Update', 0, NULL, NULL, 'N;'),
('ProductionWastage.*', 1, NULL, NULL, 'N;'),
('ProductionWastage.Admin', 0, NULL, NULL, 'N;'),
('ProductionWastage.Create', 0, NULL, NULL, 'N;'),
('ProductionWastage.Delete', 0, NULL, NULL, 'N;'),
('ProductionWastage.DeleteAll', 0, NULL, NULL, 'N;'),
('ProductionWastage.Update', 0, NULL, NULL, 'N;'),
('PurchaseOrder.*', 1, NULL, NULL, 'N;'),
('PurchaseOrder.Admin', 0, NULL, NULL, 'N;'),
('PurchaseOrder.AdminPO', 0, NULL, NULL, 'N;'),
('PurchaseOrder.CreateAll', 0, NULL, NULL, 'N;'),
('PurchaseOrder.CreateFromSelected', 0, NULL, NULL, 'N;'),
('PurchaseOrder.Delete', 0, NULL, NULL, 'N;'),
('PurchaseOrder.DeleteAll', 0, NULL, NULL, 'N;'),
('PurchaseOrder.RequisitionPreview', 0, NULL, NULL, 'N;'),
('PurchaseOrder.Update', 0, NULL, NULL, 'N;'),
('PurchaseProcurement.*', 1, NULL, NULL, 'N;'),
('PurchaseProcurement.Admin', 0, NULL, NULL, 'N;'),
('PurchaseProcurement.Create', 0, NULL, NULL, 'N;'),
('PurchaseProcurement.Delete', 0, NULL, NULL, 'N;'),
('PurchaseProcurement.DeleteAll', 0, NULL, NULL, 'N;'),
('PurchaseProcurement.DeleteFromUpdate', 0, NULL, NULL, 'N;'),
('PurchaseProcurement.ProcurementPreview', 0, NULL, NULL, 'N;'),
('PurchaseProcurement.Update', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.*', 1, NULL, NULL, 'N;'),
('PurchaseRcvRtn.Admin', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.AdminReceive', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.AllReceive', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.Delete', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.DeleteAll', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.ReceiveHistory', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.Return', 0, NULL, NULL, 'N;'),
('PurchaseRcvRtn.Update', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.*', 1, NULL, NULL, 'N;'),
('PurchaseRequisition.Admin', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.AdminPP', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.AdminPRFromSR', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.Create', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.Delete', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.DeleteAll', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.DeleteFromUpdate', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.PurchaseReport', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.PurchaseReportView', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.ReqFromItemsWarningQty', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.ReqFromItemsWarningQtyView', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.ReqFromItemsWarnQtyCreate', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.ReqFromSO', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.ReqFromSoCreate', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.ReqFromSOView', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.ReqFromStoreReq', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.RequisitionPreview', 0, NULL, NULL, 'N;'),
('PurchaseRequisition.Update', 0, NULL, NULL, 'N;'),
('ReportPdf.*', 1, NULL, NULL, 'N;'),
('ReportPdf.ConsumptionReportPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.CustomerLedgerAllPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.CustomerLedgerSpecificPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.PosReportPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.ProductionReportPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.PurchaseReportPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.SalesReportPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.StockReportPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.StockReportStorePdf', 0, NULL, NULL, 'N;'),
('ReportPdf.StoreReqReportPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.SupplierLedgerAllPdf', 0, NULL, NULL, 'N;'),
('ReportPdf.SupplierLedgerSpecificPdf', 0, NULL, NULL, 'N;'),
('ReportXls.*', 1, NULL, NULL, 'N;'),
('ReportXls.Index', 0, NULL, NULL, 'N;'),
('SaleOrder.*', 1, NULL, NULL, 'N;'),
('SaleOrder.Admin', 0, NULL, NULL, 'N;'),
('SaleOrder.Create', 0, NULL, NULL, 'N;'),
('SaleOrder.Delete', 0, NULL, NULL, 'N;'),
('SaleOrder.DeleteAll', 0, NULL, NULL, 'N;'),
('SaleOrder.DeleteFromUpdate', 0, NULL, NULL, 'N;'),
('SaleOrder.SalesReport', 0, NULL, NULL, 'N;'),
('SaleOrder.SalesReportView', 0, NULL, NULL, 'N;'),
('SaleOrder.SoPreview', 0, NULL, NULL, 'N;'),
('SaleOrder.Start', 0, NULL, NULL, 'N;'),
('SaleOrder.Stop', 0, NULL, NULL, 'N;'),
('SaleOrder.Update', 0, NULL, NULL, 'N;'),
('SellDelvRtn.*', 1, NULL, NULL, 'N;'),
('SellDelvRtn.Admin', 0, NULL, NULL, 'N;'),
('SellDelvRtn.AdminDelivery', 0, NULL, NULL, 'N;'),
('SellDelvRtn.AllDeliver', 0, NULL, NULL, 'N;'),
('SellDelvRtn.ChallanNoPreview', 0, NULL, NULL, 'N;'),
('SellDelvRtn.Delete', 0, NULL, NULL, 'N;'),
('SellDelvRtn.DeleteAll', 0, NULL, NULL, 'N;'),
('SellDelvRtn.DeliveryHistory', 0, NULL, NULL, 'N;'),
('SellDelvRtn.Return', 0, NULL, NULL, 'N;'),
('SellDelvRtn.Update', 0, NULL, NULL, 'N;'),
('SellingPrice.*', 1, NULL, NULL, 'N;'),
('SellingPrice.AddSellingPrice', 0, NULL, NULL, 'N;'),
('SellingPrice.Admin', 0, NULL, NULL, 'N;'),
('SellingPrice.Delete', 0, NULL, NULL, 'N;'),
('SellingPrice.PriceHistory', 0, NULL, NULL, 'N;'),
('SellingPrice.Update', 0, NULL, NULL, 'N;'),
('Site.*', 1, NULL, NULL, 'N;'),
('Site.DashBoard', 0, NULL, NULL, 'N;'),
('Site.Error', 0, NULL, NULL, 'N;'),
('Site.Index', 0, NULL, NULL, 'N;'),
('Site.Login', 0, NULL, NULL, 'N;'),
('Site.Logout', 0, NULL, NULL, 'N;'),
('StockTransferHistory.*', 1, NULL, NULL, 'N;'),
('StockTransferHistory.Admin', 0, NULL, NULL, 'N;'),
('StockTransferHistory.AdminForReceive', 0, NULL, NULL, 'N;'),
('StockTransferHistory.Delete', 0, NULL, NULL, 'N;'),
('StockTransferHistory.ReceiveStock', 0, NULL, NULL, 'N;'),
('StockTransferHistory.Update', 0, NULL, NULL, 'N;'),
('StorckTranferHistoryFromTempToMain.*', 1, NULL, NULL, 'N;'),
('StorckTranferHistoryFromTempToMain.Admin', 0, NULL, NULL, 'N;'),
('StorckTranferHistoryFromTempToMain.Delete', 0, NULL, NULL, 'N;'),
('StorckTranferHistoryFromTempToMain.Update', 0, NULL, NULL, 'N;'),
('StoreInventory.*', 1, NULL, NULL, 'N;'),
('StoreInventory.Admin', 0, NULL, NULL, 'N;'),
('StoreInventory.Create', 0, NULL, NULL, 'N;'),
('StoreInventory.Delete', 0, NULL, NULL, 'N;'),
('StoreInventory.DeleteAll', 0, NULL, NULL, 'N;'),
('StoreInventory.SendFromTempToMainInv', 0, NULL, NULL, 'N;'),
('StoreInventory.SendFromTempToMainInvView', 0, NULL, NULL, 'N;'),
('StoreInventory.StockReport', 0, NULL, NULL, 'N;'),
('StoreInventory.StockReportView', 0, NULL, NULL, 'N;'),
('StoreInventory.TransferStockFromTempToMainInvCreate', 0, NULL, NULL, 'N;'),
('StoreInventory.Update', 0, NULL, NULL, 'N;'),
('StoreReqDR.*', 1, NULL, NULL, 'N;'),
('StoreReqDR.Admin', 0, NULL, NULL, 'N;'),
('StoreReqDR.AdminApprove', 0, NULL, NULL, 'N;'),
('StoreReqDR.AdminDelivery', 0, NULL, NULL, 'N;'),
('StoreReqDR.AdminReturn', 0, NULL, NULL, 'N;'),
('StoreReqDR.AllApprove', 0, NULL, NULL, 'N;'),
('StoreReqDR.AllDelivery', 0, NULL, NULL, 'N;'),
('StoreReqDR.Delete', 0, NULL, NULL, 'N;'),
('StoreReqDR.DeleteAll', 0, NULL, NULL, 'N;'),
('StoreReqDR.Return', 0, NULL, NULL, 'N;'),
('StoreReqDR.Update', 0, NULL, NULL, 'N;'),
('StoreRequisition.*', 1, NULL, NULL, 'N;'),
('StoreRequisition.Admin', 0, NULL, NULL, 'N;'),
('StoreRequisition.Create', 0, NULL, NULL, 'N;'),
('StoreRequisition.Delete', 0, NULL, NULL, 'N;'),
('StoreRequisition.DeleteAll', 0, NULL, NULL, 'N;'),
('StoreRequisition.DeleteFromUpdate', 0, NULL, NULL, 'N;'),
('StoreRequisition.RequisitionPreview', 0, NULL, NULL, 'N;'),
('StoreRequisition.StoreReqReport', 0, NULL, NULL, 'N;'),
('StoreRequisition.StoreReqReportView', 0, NULL, NULL, 'N;'),
('StoreRequisition.Update', 0, NULL, NULL, 'N;'),
('Stores.*', 1, NULL, NULL, 'N;'),
('Stores.Admin', 0, NULL, NULL, 'N;'),
('Stores.Create', 0, NULL, NULL, 'N;'),
('Stores.CreateStoreFromOutSide', 0, NULL, NULL, 'N;'),
('Stores.Delete', 0, NULL, NULL, 'N;'),
('Stores.Update', 0, NULL, NULL, 'N;'),
('Sub Admin', 2, 'Sub Admin', NULL, 'N;'),
('SuperAdmin', 2, NULL, NULL, 'N;'),
('SupplierContactPersons.*', 1, NULL, NULL, 'N;'),
('SupplierContactPersons.AddContactPerson', 0, NULL, NULL, 'N;'),
('SupplierContactPersons.Admin', 0, NULL, NULL, 'N;'),
('SupplierContactPersons.Contacts', 0, NULL, NULL, 'N;'),
('SupplierContactPersons.Create', 0, NULL, NULL, 'N;'),
('SupplierContactPersons.Delete', 0, NULL, NULL, 'N;'),
('SupplierContactPersons.Update', 0, NULL, NULL, 'N;'),
('SupplierMr.*', 1, NULL, NULL, 'N;'),
('SupplierMr.AddMoneyReceipt', 0, NULL, NULL, 'N;'),
('SupplierMr.Admin', 0, NULL, NULL, 'N;'),
('SupplierMr.Delete', 0, NULL, NULL, 'N;'),
('SupplierMr.DeleteAll', 0, NULL, NULL, 'N;'),
('SupplierMr.MoneyReceiptHistory', 0, NULL, NULL, 'N;'),
('SupplierMr.MrPreview', 0, NULL, NULL, 'N;'),
('SupplierMr.Update', 0, NULL, NULL, 'N;'),
('Suppliers.*', 1, NULL, NULL, 'N;'),
('Suppliers.Admin', 0, NULL, NULL, 'N;'),
('Suppliers.AdminMoneyReceipt', 0, NULL, NULL, 'N;'),
('Suppliers.Create', 0, NULL, NULL, 'N;'),
('Suppliers.CreateSupplierFromOutSide', 0, NULL, NULL, 'N;'),
('Suppliers.Delete', 0, NULL, NULL, 'N;'),
('Suppliers.SupplierLedgerAll', 0, NULL, NULL, 'N;'),
('Suppliers.SupplierLedgerAllView', 0, NULL, NULL, 'N;'),
('Suppliers.SupplierLedgerSpecific', 0, NULL, NULL, 'N;'),
('Suppliers.SupplierLedgerSpecificView', 0, NULL, NULL, 'N;'),
('Suppliers.Update', 0, NULL, NULL, 'N;'),
('Suppliers.View', 0, NULL, NULL, 'N;'),
('Users.*', 1, NULL, NULL, 'N;'),
('Users.Admin', 0, NULL, NULL, 'N;'),
('Users.AdminAssignStore', 0, NULL, NULL, 'N;'),
('Users.Create', 0, NULL, NULL, 'N;'),
('Users.Delete', 0, NULL, NULL, 'N;'),
('Users.Update', 0, NULL, NULL, 'N;'),
('UserStore.*', 1, NULL, NULL, 'N;'),
('UserStore.Admin', 0, NULL, NULL, 'N;'),
('UserStore.AssignStoreToThisUser', 0, NULL, NULL, 'N;'),
('UserStore.ChangeStatus', 0, NULL, NULL, 'N;'),
('UserStore.Delete', 0, NULL, NULL, 'N;'),
('UserStore.Update', 0, NULL, NULL, 'N;'),
('YourCompany.*', 1, NULL, NULL, 'N;'),
('YourCompany.Admin', 0, NULL, NULL, 'N;'),
('YourCompany.Create', 0, NULL, NULL, 'N;'),
('YourCompany.Delete', 0, NULL, NULL, 'N;'),
('YourCompany.Update', 0, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('POS User', 'Members.AvailablePointsOfThis'),
('POS User', 'Members.CreateMembersFromOutSide'),
('POS User', 'Members.MembersAVpoint'),
('POS User', 'Pos.AuthorizationCheck'),
('POS User', 'Pos.AuthorizationCheckReprint'),
('POS User', 'Pos.AuthorizationCheckUpdate'),
('POS User', 'Pos.AuthorizationCheckVoid'),
('POS User', 'Pos.Create'),
('POS User', 'Pos.Reprint'),
('POS User', 'Pos.SoReportOfThis'),
('POS User', 'Pos.Void'),
('POS User', 'Pos.VoidPos'),
('POS User', 'Pos.VoidPosUndo'),
('POS User', 'Pos.VoidUpdate');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE IF NOT EXISTS `banks` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cats`
--

INSERT INTO `cats` (`id`, `name`) VALUES
(7, 'Raw');

-- --------------------------------------------------------

--
-- Table structure for table `cats_sub`
--

CREATE TABLE IF NOT EXISTS `cats_sub` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cats_sub`
--

INSERT INTO `cats_sub` (`id`, `name`) VALUES
(1, 'Ladies'),
(2, 'Gents'),
(3, 'Child'),
(4, 'Hybrid'),
(5, 'LDPE Foam');

-- --------------------------------------------------------

--
-- Table structure for table `costing_price`
--

CREATE TABLE IF NOT EXISTS `costing_price` (
  `id` int(11) NOT NULL,
  `item` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL,
  `iso2` char(2) DEFAULT NULL,
  `iso3` char(3) DEFAULT NULL,
  `country` varchar(62) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso2`, `iso3`, `country`) VALUES
(1, 'AF', 'AFG', 'Afghanistan'),
(2, 'AX', 'ALA', 'Ã…land Islands'),
(3, 'AL', 'ALB', 'Albania'),
(4, 'DZ', 'DZA', 'Algeria (El DjazaÃ¯r)'),
(5, 'AS', 'ASM', 'American Samoa'),
(6, 'AD', 'AND', 'Andorra'),
(7, 'AO', 'AGO', 'Angola'),
(8, 'AI', 'AIA', 'Anguilla'),
(9, 'AQ', 'ATA', 'Antarctica'),
(10, 'AG', 'ATG', 'Antigua and Barbuda'),
(11, 'AR', 'ARG', 'Argentina'),
(12, 'AM', 'ARM', 'Armenia'),
(13, 'AW', 'ABW', 'Aruba'),
(14, 'AU', 'AUS', 'Australia'),
(15, 'AT', 'AUT', 'Austria'),
(16, 'AZ', 'AZE', 'Azerbaijan'),
(17, 'BS', 'BHS', 'Bahamas'),
(18, 'BH', 'BHR', 'Bahrain'),
(19, 'BD', 'BGD', 'Bangladesh'),
(20, 'BB', 'BRB', 'Barbados'),
(21, 'BY', 'BLR', 'Belarus'),
(22, 'BE', 'BEL', 'Belgium'),
(23, 'BZ', 'BLZ', 'Belize'),
(24, 'BJ', 'BEN', 'Benin'),
(25, 'BM', 'BMU', 'Bermuda'),
(26, 'BT', 'BTN', 'Bhutan'),
(27, 'BO', 'BOL', 'Bolivia'),
(28, 'BA', 'BIH', 'Bosnia and Herzegovina'),
(29, 'BW', 'BWA', 'Botswana'),
(30, 'BV', 'BVT', 'Bouvet Island'),
(31, 'BR', 'BRA', 'Brazil'),
(32, 'IO', 'IOT', 'British Indian Ocean Territory'),
(33, 'BN', 'BRN', 'Brunei Darussalam'),
(34, 'BG', 'BGR', 'Bulgaria'),
(35, 'BF', 'BFA', 'Burkina Faso'),
(36, 'BI', 'BDI', 'Burundi'),
(37, 'KH', 'KHM', 'Cambodia'),
(38, 'CM', 'CMR', 'Cameroon'),
(39, 'CA', 'CAN', 'Canada'),
(40, 'CV', 'CPV', 'Cape Verde'),
(41, 'KY', 'CYM', 'Cayman Islands'),
(42, 'CF', 'CAF', 'Central African Republic'),
(43, 'TD', 'TCD', 'Chad (T''Chad)'),
(44, 'CL', 'CHL', 'Chile'),
(45, 'CN', 'CHN', 'China'),
(46, 'CX', 'CXR', 'Christmas Island'),
(47, 'CC', 'CCK', 'Cocos (Keeling) Islands'),
(48, 'CO', 'COL', 'Colombia'),
(49, 'KM', 'COM', 'Comoros'),
(50, 'CG', 'COG', 'Congo, Republic Of'),
(51, 'CD', 'COD', 'Congo, The Democratic Republic of the (formerly Zaire)'),
(52, 'CK', 'COK', 'Cook Islands'),
(53, 'CR', 'CRI', 'Costa Rica'),
(54, 'CI', 'CIV', 'CÃ”te D''Ivoire (Ivory Coast)'),
(55, 'HR', 'HRV', 'Croatia (hrvatska)'),
(56, 'CU', 'CUB', 'Cuba'),
(57, 'CY', 'CYP', 'Cyprus'),
(58, 'CZ', 'CZE', 'Czech Republic'),
(59, 'DK', 'DNK', 'Denmark'),
(60, 'DJ', 'DJI', 'Djibouti'),
(61, 'DM', 'DMA', 'Dominica'),
(62, 'DO', 'DOM', 'Dominican Republic'),
(63, 'EC', 'ECU', 'Ecuador'),
(64, 'EG', 'EGY', 'Egypt'),
(65, 'SV', 'SLV', 'El Salvador'),
(66, 'GQ', 'GNQ', 'Equatorial Guinea'),
(67, 'ER', 'ERI', 'Eritrea'),
(68, 'EE', 'EST', 'Estonia'),
(69, 'ET', 'ETH', 'Ethiopia'),
(70, 'FO', 'FRO', 'Faeroe Islands'),
(71, 'FK', 'FLK', 'Falkland Islands (Malvinas)'),
(72, 'FJ', 'FJI', 'Fiji'),
(73, 'FI', 'FIN', 'Finland'),
(74, 'FR', 'FRA', 'France'),
(75, 'GF', 'GUF', 'French Guiana'),
(76, 'PF', 'PYF', 'French Polynesia'),
(77, 'TF', 'ATF', 'French Southern Territories'),
(78, 'GA', 'GAB', 'Gabon'),
(79, 'GM', 'GMB', 'Gambia, The'),
(80, 'GE', 'GEO', 'Georgia'),
(81, 'DE', 'DEU', 'Germany (Deutschland)'),
(82, 'GH', 'GHA', 'Ghana'),
(83, 'GI', 'GIB', 'Gibraltar'),
(84, 'GB', 'GBR', 'Great Britain'),
(85, 'GR', 'GRC', 'Greece'),
(86, 'GL', 'GRL', 'Greenland'),
(87, 'GD', 'GRD', 'Grenada'),
(88, 'GP', 'GLP', 'Guadeloupe'),
(89, 'GU', 'GUM', 'Guam'),
(90, 'GT', 'GTM', 'Guatemala'),
(91, 'GN', 'GIN', 'Guinea'),
(92, 'GW', 'GNB', 'Guinea-bissau'),
(93, 'GY', 'GUY', 'Guyana'),
(94, 'HT', 'HTI', 'Haiti'),
(95, 'HM', 'HMD', 'Heard Island and Mcdonald Islands'),
(96, 'HN', 'HND', 'Honduras'),
(97, 'HK', 'HKG', 'Hong Kong (Special Administrative Region of China)'),
(98, 'HU', 'HUN', 'Hungary'),
(99, 'IS', 'ISL', 'Iceland'),
(100, 'IN', 'IND', 'India'),
(101, 'ID', 'IDN', 'Indonesia'),
(102, 'IR', 'IRN', 'Iran (Islamic Republic of Iran)'),
(103, 'IQ', 'IRQ', 'Iraq'),
(104, 'IE', 'IRL', 'Ireland'),
(105, 'IL', 'ISR', 'Israel'),
(106, 'IT', 'ITA', 'Italy'),
(107, 'JM', 'JAM', 'Jamaica'),
(108, 'JP', 'JPN', 'Japan'),
(109, 'JO', 'JOR', 'Jordan (Hashemite Kingdom of Jordan)'),
(110, 'KZ', 'KAZ', 'Kazakhstan'),
(111, 'KE', 'KEN', 'Kenya'),
(112, 'KI', 'KIR', 'Kiribati'),
(113, 'KP', 'PRK', 'Korea (Democratic Peoples Republic pf [North] Korea)'),
(114, 'KR', 'KOR', 'Korea (Republic of [South] Korea)'),
(115, 'KW', 'KWT', 'Kuwait'),
(116, 'KG', 'KGZ', 'Kyrgyzstan'),
(117, 'LA', 'LAO', 'Lao People''s Democratic Republic'),
(118, 'LV', 'LVA', 'Latvia'),
(119, 'LB', 'LBN', 'Lebanon'),
(120, 'LS', 'LSO', 'Lesotho'),
(121, 'LR', 'LBR', 'Liberia'),
(122, 'LY', 'LBY', 'Libya (Libyan Arab Jamahirya)'),
(123, 'LI', 'LIE', 'Liechtenstein (FÃ¼rstentum Liechtenstein)'),
(124, 'LT', 'LTU', 'Lithuania'),
(125, 'LU', 'LUX', 'Luxembourg'),
(126, 'MO', 'MAC', 'Macao (Special Administrative Region of China)'),
(127, 'MK', 'MKD', 'Macedonia (Former Yugoslav Republic of Macedonia)'),
(128, 'MG', 'MDG', 'Madagascar'),
(129, 'MW', 'MWI', 'Malawi'),
(130, 'MY', 'MYS', 'Malaysia'),
(131, 'MV', 'MDV', 'Maldives'),
(132, 'ML', 'MLI', 'Mali'),
(133, 'MT', 'MLT', 'Malta'),
(134, 'MH', 'MHL', 'Marshall Islands'),
(135, 'MQ', 'MTQ', 'Martinique'),
(136, 'MR', 'MRT', 'Mauritania'),
(137, 'MU', 'MUS', 'Mauritius'),
(138, 'YT', 'MYT', 'Mayotte'),
(139, 'MX', 'MEX', 'Mexico'),
(140, 'FM', 'FSM', 'Micronesia (Federated States of Micronesia)'),
(141, 'MD', 'MDA', 'Moldova'),
(142, 'MC', 'MCO', 'Monaco'),
(143, 'MN', 'MNG', 'Mongolia'),
(144, 'MS', 'MSR', 'Montserrat'),
(145, 'MA', 'MAR', 'Morocco'),
(146, 'MZ', 'MOZ', 'Mozambique (MoÃ§ambique)'),
(147, 'MM', 'MMR', 'Myanmar (formerly Burma)'),
(148, 'NA', 'NAM', 'Namibia'),
(149, 'NR', 'NRU', 'Nauru'),
(150, 'NP', 'NPL', 'Nepal'),
(151, 'NL', 'NLD', 'Netherlands'),
(152, 'AN', 'ANT', 'Netherlands Antilles'),
(153, 'NC', 'NCL', 'New Caledonia'),
(154, 'NZ', 'NZL', 'New Zealand'),
(155, 'NI', 'NIC', 'Nicaragua'),
(156, 'NE', 'NER', 'Niger'),
(157, 'NG', 'NGA', 'Nigeria'),
(158, 'NU', 'NIU', 'Niue'),
(159, 'NF', 'NFK', 'Norfolk Island'),
(160, 'MP', 'MNP', 'Northern Mariana Islands'),
(161, 'NO', 'NOR', 'Norway'),
(162, 'OM', 'OMN', 'Oman'),
(163, 'PK', 'PAK', 'Pakistan'),
(164, 'PW', 'PLW', 'Palau'),
(165, 'PS', 'PSE', 'Palestinian Territories'),
(166, 'PA', 'PAN', 'Panama'),
(167, 'PG', 'PNG', 'Papua New Guinea'),
(168, 'PY', 'PRY', 'Paraguay'),
(169, 'PE', 'PER', 'Peru'),
(170, 'PH', 'PHL', 'Philippines'),
(171, 'PN', 'PCN', 'Pitcairn'),
(172, 'PL', 'POL', 'Poland'),
(173, 'PT', 'PRT', 'Portugal'),
(174, 'PR', 'PRI', 'Puerto Rico'),
(175, 'QA', 'QAT', 'Qatar'),
(176, 'RE', 'REU', 'RÃ‰union'),
(177, 'RO', 'ROU', 'Romania'),
(178, 'RU', 'RUS', 'Russian Federation'),
(179, 'RW', 'RWA', 'Rwanda'),
(180, 'SH', 'SHN', 'Saint Helena'),
(181, 'KN', 'KNA', 'Saint Kitts and Nevis'),
(182, 'LC', 'LCA', 'Saint Lucia'),
(183, 'PM', 'SPM', 'Saint Pierre and Miquelon'),
(184, 'VC', 'VCT', 'Saint Vincent and the Grenadines'),
(185, 'WS', 'WSM', 'Samoa (formerly Western Samoa)'),
(186, 'SM', 'SMR', 'San Marino (Republic of)'),
(187, 'ST', 'STP', 'Sao Tome and Principe'),
(188, 'SA', 'SAU', 'Saudi Arabia (Kingdom of Saudi Arabia)'),
(189, 'SN', 'SEN', 'Senegal'),
(190, 'CS', 'SCG', 'Serbia and Montenegro (formerly Yugoslavia)'),
(191, 'SC', 'SYC', 'Seychelles'),
(192, 'SL', 'SLE', 'Sierra Leone'),
(193, 'SG', 'SGP', 'Singapore'),
(194, 'SK', 'SVK', 'Slovakia (Slovak Republic)'),
(195, 'SI', 'SVN', 'Slovenia'),
(196, 'SB', 'SLB', 'Solomon Islands'),
(197, 'SO', 'SOM', 'Somalia'),
(198, 'ZA', 'ZAF', 'South Africa (zuid Afrika)'),
(199, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands'),
(200, 'ES', 'ESP', 'Spain (espaÃ±a)'),
(201, 'LK', 'LKA', 'Sri Lanka'),
(202, 'SD', 'SDN', 'Sudan'),
(203, 'SR', 'SUR', 'Suriname'),
(204, 'SJ', 'SJM', 'Svalbard and Jan Mayen'),
(205, 'SZ', 'SWZ', 'Swaziland'),
(206, 'SE', 'SWE', 'Sweden'),
(207, 'CH', 'CHE', 'Switzerland (Confederation of Helvetia)'),
(208, 'SY', 'SYR', 'Syrian Arab Republic'),
(209, 'TW', 'TWN', 'Taiwan ("Chinese Taipei" for IOC)'),
(210, 'TJ', 'TJK', 'Tajikistan'),
(211, 'TZ', 'TZA', 'Tanzania'),
(212, 'TH', 'THA', 'Thailand'),
(213, 'TL', 'TLS', 'Timor-Leste (formerly East Timor)'),
(214, 'TG', 'TGO', 'Togo'),
(215, 'TK', 'TKL', 'Tokelau'),
(216, 'TO', 'TON', 'Tonga'),
(217, 'TT', 'TTO', 'Trinidad and Tobago'),
(218, 'TN', 'TUN', 'Tunisia'),
(219, 'TR', 'TUR', 'Turkey'),
(220, 'TM', 'TKM', 'Turkmenistan'),
(221, 'TC', 'TCA', 'Turks and Caicos Islands'),
(222, 'TV', 'TUV', 'Tuvalu'),
(223, 'UG', 'UGA', 'Uganda'),
(224, 'UA', 'UKR', 'Ukraine'),
(225, 'AE', 'ARE', 'United Arab Emirates'),
(226, 'GB', 'GBR', 'United Kingdom (Great Britain)'),
(227, 'US', 'USA', 'United States'),
(228, 'UM', 'UMI', 'United States Minor Outlying Islands'),
(229, 'UY', 'URY', 'Uruguay'),
(230, 'UZ', 'UZB', 'Uzbekistan'),
(231, 'VU', 'VUT', 'Vanuatu'),
(232, 'VA', 'VAT', 'Vatican City (Holy See)'),
(233, 'VE', 'VEN', 'Venezuela'),
(234, 'VN', 'VNM', 'Viet Nam'),
(235, 'VG', 'VGB', 'Virgin Islands, British'),
(236, 'VI', 'VIR', 'Virgin Islands, U.S.'),
(237, 'WF', 'WLF', 'Wallis and Futuna'),
(238, 'EH', 'ESH', 'Western Sahara (formerly Spanish Sahara)'),
(239, 'YE', 'YEM', 'Yemen (Arab Republic)'),
(240, 'ZM', 'ZMB', 'Zambia'),
(241, 'ZW', 'ZWE', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `credit_memo`
--

CREATE TABLE IF NOT EXISTS `credit_memo` (
  `id` int(11) NOT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text,
  `company_contact_no` varchar(20) DEFAULT NULL,
  `company_fax` varchar(20) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_web` varchar(50) DEFAULT NULL,
  `opening_amount` double DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `id_no`, `company_name`, `company_address`, `company_contact_no`, `company_fax`, `company_email`, `company_web`, `opening_amount`) VALUES
(1, '20160120110127', 'Customer One', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_bill`
--

CREATE TABLE IF NOT EXISTS `customer_bill` (
  `id` int(11) NOT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `challan_no` varchar(255) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_bill`
--

INSERT INTO `customer_bill` (`id`, `max_sl_no`, `sl_no`, `customer_id`, `challan_no`, `bill_date`, `due_date`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(20, 1, '201601241', 1, '201601241', '2016-01-24', '2016-01-24', 1, '2016-01-24 01:19:15', NULL, NULL),
(21, 1, '201601241', 1, '201601242', '2016-01-24', '2016-01-24', 1, '2016-01-24 01:19:15', NULL, NULL),
(22, 1, '201601241', 1, '201601243', '2016-01-24', '2016-01-24', 1, '2016-01-24 01:19:15', NULL, NULL),
(23, 1, '201601241', 1, '201601244', '2016-01-24', '2016-01-24', 1, '2016-01-24 01:19:15', NULL, NULL),
(24, 2, '201601242', 1, '201601245', '2016-01-24', '2016-01-24', 1, '2016-01-24 11:22:08', NULL, NULL),
(25, 2, '201601242', 1, '201601246', '2016-01-24', '2016-01-24', 1, '2016-01-24 11:22:08', NULL, NULL),
(26, 2, '201601242', 1, '201601247', '2016-01-24', '2016-01-24', 1, '2016-01-24 11:22:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_contact_persons`
--

CREATE TABLE IF NOT EXISTS `customer_contact_persons` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `contact_number1` varchar(20) DEFAULT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `contact_number3` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_contact_persons`
--

INSERT INTO `customer_contact_persons` (`id`, `company_id`, `contact_person_name`, `designation_id`, `contact_number1`, `contact_number2`, `contact_number3`, `email`) VALUES
(1, 1, 'Contact Person One', 1, '123456789', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_mr`
--

CREATE TABLE IF NOT EXISTS `customer_mr` (
  `id` int(11) NOT NULL,
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
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_mr`
--

INSERT INTO `customer_mr` (`id`, `max_sl_no`, `sl_no`, `bill_no`, `customer_id`, `date`, `received_type`, `bank_name`, `cheque_no`, `cheque_date`, `paid_amount`, `discount`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(5, 1, '201601241', '201601241', 1, '2016-01-24', 20, '', '', '0000-00-00', 73499.11, 0, 1, '2016-01-24 01:19:49', NULL, NULL),
(6, 2, '201601242', '201601242', 1, '2016-01-24', 20, '', '', '0000-00-00', 54506.29, 0, 1, '2016-01-24 11:28:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`) VALUES
(1, 'Department One'),
(2, 'Sales'),
(3, 'Purchase'),
(4, 'store'),
(5, 'production');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE IF NOT EXISTS `designations` (
  `id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation`) VALUES
(4, 'Production Manager'),
(5, 'untit manager'),
(6, 'manager'),
(7, 'engineer');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` text,
  `signature` varchar(600) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `full_name`, `designation_id`, `department_id`, `id_no`, `contact_no`, `email`, `address`, `signature`) VALUES
(11, 'Kobir', 6, 3, '20160425110410', '01720378851', '', '', ''),
(12, 'Ahsan', 4, 5, '20160425110435', '01534601351', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `name`) VALUES
(1, 'A'),
(2, 'G');

-- --------------------------------------------------------

--
-- Table structure for table `import_document`
--

CREATE TABLE IF NOT EXISTS `import_document` (
  `id` int(11) NOT NULL,
  `lc_id` int(11) DEFAULT NULL,
  `pi_no` varchar(255) DEFAULT NULL,
  `pi_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `noOfReceivedSack` double NOT NULL,
  `weightPerSack` double NOT NULL,
  `unit` int(11) NOT NULL,
  `item` int(11) DEFAULT NULL,
  `stock_in` double DEFAULT NULL,
  `stock_out` double DEFAULT NULL,
  `costing_price` double DEFAULT NULL,
  `sell_price` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `date`, `store`, `noOfReceivedSack`, `weightPerSack`, `unit`, `item`, `stock_in`, `stock_out`, `costing_price`, `sell_price`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, '2016-01-21', 1, 0, 0, 0, 1, 100000, NULL, 550, NULL, 1, '2016-01-21 04:57:31', NULL, NULL),
(2, '2016-01-21', 1, 0, 0, 0, 2, 100000, NULL, 550, NULL, 1, '2016-01-21 04:57:31', NULL, NULL),
(3, '2016-01-21', 1, 0, 0, 0, 1, NULL, 10, NULL, NULL, 1, '2016-01-21 05:00:32', NULL, NULL),
(4, '2016-01-21', 1, 0, 0, 0, 2, NULL, 10, NULL, NULL, 1, '2016-01-21 05:00:32', NULL, NULL),
(5, '2016-01-21', 1, 0, 0, 0, 2, NULL, 5, NULL, NULL, 1, '2016-01-21 05:02:27', NULL, NULL),
(6, '2016-01-21', 1, 0, 0, 0, 2, NULL, 1, NULL, NULL, 1, '2016-01-21 05:03:37', NULL, NULL),
(7, '2016-01-21', 1, 0, 0, 0, 3, 100000, NULL, 50, NULL, 1, '2016-01-21 16:06:10', NULL, NULL),
(8, '2016-01-21', 1, 0, 0, 0, 3, NULL, 10, NULL, NULL, 1, '2016-01-21 16:06:24', NULL, NULL),
(9, '2016-01-21', 1, 0, 0, 0, 2, NULL, 1, NULL, NULL, 1, '2016-01-21 16:13:11', NULL, NULL),
(10, '2016-01-23', 1, 0, 0, 0, 1, NULL, 2, NULL, NULL, 1, '2016-01-23 21:09:06', NULL, NULL),
(11, '2016-01-23', 1, 0, 0, 0, 3, NULL, 2, NULL, NULL, 1, '2016-01-23 21:09:06', NULL, NULL),
(12, '2016-01-23', 1, 0, 0, 0, 2, NULL, 2, NULL, NULL, 1, '2016-01-23 21:38:35', NULL, NULL),
(13, '2016-01-23', 1, 0, 0, 0, 1, NULL, 2, NULL, NULL, 1, '2016-01-23 21:38:35', NULL, NULL),
(14, '2016-01-23', 1, 0, 0, 0, 2, NULL, 10, NULL, NULL, 1, '2016-01-23 21:40:37', NULL, NULL),
(15, '2016-01-23', 1, 0, 0, 0, 1, NULL, 15, NULL, NULL, 1, '2016-01-23 21:41:46', NULL, NULL),
(16, '2016-01-23', 1, 0, 0, 0, 1, 100000, NULL, 550, NULL, 1, '2016-01-23 22:30:18', NULL, NULL),
(17, '2016-01-23', 1, 0, 0, 0, 2, 100000, NULL, 550, NULL, 1, '2016-01-23 22:30:18', NULL, NULL),
(18, '2016-01-23', 1, 0, 0, 0, 4, 10000, NULL, 10, NULL, 1, '2016-01-23 23:23:45', NULL, NULL),
(19, '2016-01-23', 1, 0, 0, 0, 4, NULL, 10, NULL, NULL, 1, '2016-01-23 23:23:55', NULL, NULL),
(20, '2016-01-23', 1, 0, 0, 0, 3, NULL, 5, NULL, NULL, 1, '2016-01-23 23:38:45', NULL, NULL),
(21, '2016-01-23', 1, 0, 0, 0, 3, NULL, 5, NULL, NULL, 1, '2016-01-23 23:40:00', NULL, NULL),
(22, '2016-01-23', 1, 0, 0, 0, 2, NULL, 1, NULL, NULL, 1, '2016-01-23 23:42:40', NULL, NULL),
(23, '2016-01-23', 1, 0, 0, 0, 1, NULL, 3, NULL, NULL, 1, '2016-01-23 23:53:36', NULL, NULL),
(24, '2016-01-23', 1, 0, 0, 0, 3, NULL, 3, NULL, NULL, 1, '2016-01-23 23:53:36', NULL, NULL),
(25, '2016-01-23', 1, 0, 0, 0, 2, NULL, 3, NULL, NULL, 1, '2016-01-23 23:53:36', NULL, NULL),
(26, '2016-01-23', 1, 0, 0, 0, 1, 3, NULL, NULL, NULL, 1, '2016-01-24 00:02:35', NULL, NULL),
(27, '2016-01-23', 1, 0, 0, 0, 3, 3, NULL, NULL, NULL, 1, '2016-01-24 00:02:36', NULL, NULL),
(28, '2016-01-23', 1, 0, 0, 0, 2, 3, NULL, NULL, NULL, 1, '2016-01-24 00:02:36', NULL, NULL),
(29, '2016-01-24', 1, 0, 0, 0, 1, NULL, 2, NULL, NULL, 1, '2016-01-24 00:03:33', NULL, NULL),
(30, '2016-01-24', 1, 0, 0, 0, 3, NULL, 2, NULL, NULL, 1, '2016-01-24 00:03:33', NULL, NULL),
(31, '2016-01-24', 1, 0, 0, 0, 2, NULL, 2, NULL, NULL, 1, '2016-01-24 00:03:33', NULL, NULL),
(32, '2016-01-24', 1, 0, 0, 0, 1, NULL, 1, NULL, NULL, 1, '2016-01-24 00:04:10', NULL, NULL),
(33, '2016-01-24', 1, 0, 0, 0, 3, NULL, 1, NULL, NULL, 1, '2016-01-24 00:04:11', NULL, NULL),
(34, '2016-01-24', 1, 0, 0, 0, 2, NULL, 1, NULL, NULL, 1, '2016-01-24 00:04:11', NULL, NULL),
(35, '2016-01-24', 1, 0, 0, 0, 1, 1, NULL, NULL, NULL, 1, '2016-01-24 00:05:57', NULL, NULL),
(36, '2016-01-24', 1, 0, 0, 0, 3, 1, NULL, NULL, NULL, 1, '2016-01-24 00:05:57', NULL, NULL),
(37, '2016-01-24', 1, 0, 0, 0, 2, 1, NULL, NULL, NULL, 1, '2016-01-24 00:05:57', NULL, NULL),
(38, '2016-01-24', 1, 0, 0, 0, 1, 2, NULL, NULL, NULL, 1, '2016-01-24 00:05:57', NULL, NULL),
(39, '2016-01-24', 1, 0, 0, 0, 3, 2, NULL, NULL, NULL, 1, '2016-01-24 00:05:57', NULL, NULL),
(40, '2016-01-24', 1, 0, 0, 0, 2, 2, NULL, NULL, NULL, 1, '2016-01-24 00:05:57', NULL, NULL),
(41, '2016-01-24', 1, 0, 0, 0, 4, NULL, 3, NULL, NULL, 1, '2016-01-24 00:06:40', NULL, NULL),
(42, '2016-01-24', 1, 0, 0, 0, 4, NULL, 3, NULL, NULL, 1, '2016-01-24 00:06:58', NULL, NULL),
(43, '2016-01-24', 1, 0, 0, 0, 4, NULL, 3, NULL, NULL, 1, '2016-01-24 00:07:13', NULL, NULL),
(44, '2016-01-24', 1, 0, 0, 0, 4, NULL, 1, NULL, NULL, 1, '2016-01-24 00:07:23', NULL, NULL),
(45, '2016-01-24', 1, 0, 0, 0, 4, NULL, 3, NULL, NULL, 1, '2016-01-24 00:33:30', NULL, NULL),
(46, '2016-01-24', 1, 0, 0, 0, 4, NULL, 3, NULL, NULL, 1, '2016-01-24 00:33:44', NULL, NULL),
(47, '2016-01-24', 1, 0, 0, 0, 4, NULL, 3, NULL, NULL, 1, '2016-01-24 00:33:54', NULL, NULL),
(48, '2016-01-24', 1, 0, 0, 0, 4, NULL, 1, NULL, NULL, 1, '2016-01-24 00:34:03', NULL, NULL),
(49, '2016-01-24', 1, 0, 0, 0, 2, NULL, 2, NULL, NULL, 1, '2016-01-24 01:03:11', NULL, NULL),
(50, '2016-01-24', 1, 0, 0, 0, 2, NULL, 2, NULL, NULL, 1, '2016-01-24 01:03:24', NULL, NULL),
(51, '2016-01-24', 1, 0, 0, 0, 2, NULL, 2, NULL, NULL, 1, '2016-01-24 01:03:34', NULL, NULL),
(52, '2016-01-24', 1, 0, 0, 0, 4, NULL, 5, NULL, NULL, 1, '2016-01-24 01:11:57', NULL, NULL),
(53, '2016-01-24', 1, 0, 0, 0, 4, NULL, 5, NULL, NULL, 1, '2016-01-24 01:12:07', NULL, NULL),
(54, '2016-01-24', 1, 0, 0, 0, 4, NULL, 10, NULL, NULL, 1, '2016-01-24 01:17:44', NULL, NULL),
(55, '2016-01-24', 1, 0, 0, 0, 2, NULL, 6, NULL, NULL, 1, '2016-01-24 01:17:56', NULL, NULL),
(56, '2016-01-24', 1, 0, 0, 0, 4, NULL, 10, NULL, NULL, 1, '2016-01-24 01:18:09', NULL, NULL),
(57, '2016-01-24', 1, 0, 0, 0, 1, NULL, 3, NULL, NULL, 1, '2016-01-24 01:18:25', NULL, NULL),
(58, '2016-01-24', 1, 0, 0, 0, 3, NULL, 3, NULL, NULL, 1, '2016-01-24 01:18:25', NULL, NULL),
(59, '2016-01-24', 1, 0, 0, 0, 2, NULL, 3, NULL, NULL, 1, '2016-01-24 01:18:25', NULL, NULL),
(60, '2016-01-24', 1, 0, 0, 0, 3, NULL, 5, NULL, NULL, 1, '2016-01-24 11:20:28', NULL, NULL),
(61, '2016-01-24', 1, 0, 0, 0, 3, NULL, 5, NULL, NULL, 1, '2016-01-24 11:20:40', NULL, NULL),
(62, '2016-01-24', 1, 0, 0, 0, 4, NULL, 5, NULL, NULL, 1, '2016-01-24 11:20:52', NULL, NULL),
(63, '2016-01-25', 1, 0, 0, 0, 7, 1000, NULL, 80, NULL, 1, '2016-01-25 20:22:58', NULL, NULL),
(64, '2016-01-25', 1, 0, 0, 0, 5, 1000, NULL, 80, NULL, 1, '2016-01-25 20:22:58', NULL, NULL),
(65, '2016-01-25', 1, 0, 0, 0, 6, 1000, NULL, 80, NULL, 1, '2016-01-25 20:22:58', NULL, NULL),
(66, '2016-01-25', 1, 0, 0, 0, 4, NULL, 1, NULL, 250, 1, '2016-01-25 20:24:55', NULL, NULL),
(67, '2016-01-25', 1, 0, 0, 0, 7, NULL, 1, NULL, 100, 1, '2016-01-25 20:24:55', NULL, NULL),
(68, '2016-01-25', 1, 0, 0, 0, 5, NULL, 1, NULL, 100, 1, '2016-01-25 20:24:55', NULL, NULL),
(69, '2016-01-25', 1, 0, 0, 0, 6, NULL, 1, NULL, 100, 1, '2016-01-25 20:24:55', NULL, NULL),
(70, '2016-01-25', 1, 0, 0, 0, 2, NULL, 1, NULL, 150, 1, '2016-01-25 20:24:56', NULL, NULL),
(71, '2016-01-25', 1, 0, 0, 0, 1, NULL, 1, NULL, 160, 1, '2016-01-25 20:24:56', NULL, NULL),
(72, '2016-01-25', 1, 0, 0, 0, 3, NULL, 1, NULL, 100, 1, '2016-01-25 20:24:56', NULL, NULL),
(73, '2016-01-25', 1, 0, 0, 0, 8, NULL, 1, NULL, 200, 1, '2016-01-25 20:24:56', NULL, NULL),
(74, '2016-01-25', 1, 0, 0, 0, 8, 10000, NULL, 150, NULL, 1, '2016-01-25 20:26:14', NULL, NULL),
(75, '2016-01-25', 1, 0, 0, 0, 8, NULL, 2, NULL, 200, 1, '2016-01-25 20:26:58', NULL, NULL),
(76, '2016-01-25', 1, 0, 0, 0, 9, 10000, NULL, 25, NULL, 1, '2016-01-25 20:58:49', NULL, NULL),
(77, '2016-01-27', 1, 0, 0, 0, 4, NULL, 3, NULL, 250, 2, '2016-01-27 19:43:57', NULL, NULL),
(78, '0000-00-00', 1, 0, 0, 0, 12, 10, NULL, 100, NULL, 1, '2016-03-21 08:49:40', NULL, NULL),
(79, '0000-00-00', 1, 0, 0, 0, 13, 10, NULL, 100, NULL, 1, '2016-03-21 08:49:40', NULL, NULL),
(80, '2016-03-22', 1, 0, 0, 0, 7, 10, NULL, 20, NULL, 1, '2016-03-22 18:28:29', NULL, NULL),
(81, '2016-03-22', 1, 0, 0, 0, 5, 50, NULL, 100, NULL, 1, '2016-03-22 18:28:29', NULL, NULL),
(82, '2016-03-15', 1, 0, 0, 0, 7, 10, NULL, 100, NULL, 1, '2016-03-22 22:33:13', NULL, NULL),
(83, '2016-03-15', 1, 0, 0, 0, 5, 50, NULL, 100, NULL, 1, '2016-03-22 22:33:13', NULL, NULL),
(84, '2016-04-13', 1, 0, 0, 0, 12, 50, NULL, 1254, NULL, 1, '2016-04-13 21:20:50', NULL, NULL),
(85, '2016-04-14', 1, 0, 0, 0, 12, 50, NULL, 200, NULL, 1, '2016-04-14 05:52:07', NULL, NULL),
(86, '2016-04-07', 1, 0, 0, 0, 12, 100, NULL, 110, NULL, 1, '2016-04-14 06:13:44', NULL, NULL),
(87, '2016-04-07', 1, 0, 0, 0, 13, 100, NULL, 110, NULL, 1, '2016-04-14 06:13:44', NULL, NULL),
(88, '2016-04-07', 1, 0, 0, 0, 12, 100, NULL, 110, NULL, 1, '2016-04-14 06:13:44', NULL, NULL),
(89, '2016-04-07', 1, 0, 0, 0, 13, 100, NULL, 110, NULL, 1, '2016-04-14 06:13:44', NULL, NULL),
(90, '2016-04-14', 1, 0, 0, 0, 12, 100, NULL, 100, NULL, 1, '2016-04-14 07:27:25', NULL, NULL),
(91, '2016-04-14', 1, 0, 0, 0, 13, 100, NULL, 100, NULL, 1, '2016-04-14 07:27:25', NULL, NULL),
(92, '2016-04-07', 1, 0, 0, 0, 12, 90, NULL, 120, NULL, 1, '2016-04-14 07:39:59', NULL, NULL),
(93, '2016-04-07', 1, 0, 0, 0, 13, 90, NULL, 120, NULL, 1, '2016-04-14 07:40:00', NULL, NULL),
(94, '2016-04-07', 1, 0, 0, 0, 12, 20, NULL, 120, NULL, 1, '2016-04-14 07:54:29', NULL, NULL),
(95, '2016-04-07', 1, 0, 0, 0, 14, 200, NULL, 120, NULL, 1, '2016-04-14 07:54:30', NULL, NULL),
(96, '2016-04-07', 1, 0, 0, 0, 12, 100, NULL, 1200, NULL, 1, '2016-04-14 08:00:26', NULL, NULL),
(97, '2016-04-07', 1, 0, 0, 0, 13, 100, NULL, 1200, NULL, 1, '2016-04-14 08:00:26', NULL, NULL),
(98, '2016-04-14', 1, 0, 0, 0, 14, 5, NULL, 100, NULL, 1, '2016-04-14 22:32:09', NULL, NULL),
(99, '2016-04-06', 1, 0, 0, 0, 12, 100, NULL, 4150, NULL, 1, '2016-04-14 22:34:37', NULL, NULL),
(100, '2016-04-06', 1, 0, 0, 0, 13, 100, NULL, 120, NULL, 1, '2016-04-14 22:34:37', NULL, NULL),
(101, '2016-04-13', 1, 0, 0, 0, 12, 100, NULL, 123, NULL, 1, '2016-04-15 00:05:55', NULL, NULL),
(102, '2016-04-13', 1, 0, 0, 0, 13, 100, NULL, 123, NULL, 1, '2016-04-15 00:05:55', NULL, NULL),
(103, '2016-04-13', 1, 0, 0, 0, 12, 100, NULL, 1230, NULL, 1, '2016-04-15 00:08:51', NULL, NULL),
(104, '2016-04-13', 1, 0, 0, 0, 13, 100, NULL, 123, NULL, 1, '2016-04-15 00:08:51', NULL, NULL),
(105, '2016-04-15', 1, 0, 0, 0, 13, NULL, 12, NULL, NULL, 1, '2016-04-15 00:19:26', NULL, NULL),
(106, '2016-04-14', 1, 0, 0, 0, 13, 12, NULL, 12, NULL, 1, '2016-04-15 00:20:52', NULL, NULL),
(107, '2016-04-15', 1, 0, 0, 0, 2, 50, NULL, 12, NULL, 1, '2016-04-15 00:57:21', NULL, NULL),
(108, '2016-04-15', 1, 0, 0, 0, 12, 100, NULL, 123, NULL, 1, '2016-04-15 00:57:21', NULL, NULL),
(109, '2016-04-15', 1, 0, 0, 0, 12, 100, NULL, 123, NULL, 1, '2016-04-15 01:04:20', NULL, NULL),
(110, '2016-04-15', 1, 0, 0, 0, 13, 100, NULL, 34, NULL, 1, '2016-04-15 01:04:20', NULL, NULL),
(111, '2016-04-07', 1, 0, 0, 0, 12, 100, NULL, 123, NULL, 1, '2016-04-15 01:08:18', NULL, NULL),
(112, '2016-04-07', 1, 0, 0, 0, 13, 100, NULL, 345, NULL, 1, '2016-04-15 01:08:18', NULL, NULL),
(113, '2016-04-13', 1, 0, 0, 0, 4, NULL, 10, NULL, NULL, 1, '2016-04-15 06:15:11', NULL, NULL),
(114, '2016-04-06', 1, 0, 0, 0, 12, 100, NULL, 123, NULL, 1, '2016-04-15 06:35:21', NULL, NULL),
(115, '2016-04-06', 1, 0, 0, 0, 13, 100, NULL, 125, NULL, 1, '2016-04-15 06:35:21', NULL, NULL),
(116, '2016-04-15', 1, 0, 0, 0, 12, 100, NULL, 67, NULL, 1, '2016-04-15 06:35:57', NULL, NULL),
(117, '2016-04-15', 1, 0, 0, 0, 13, 100, NULL, 87, NULL, 1, '2016-04-15 06:35:57', NULL, NULL),
(118, '2016-04-15', 1, 0, 0, 0, 12, 100, NULL, 120, NULL, 1, '2016-04-15 06:43:12', NULL, NULL),
(119, '2016-04-15', 1, 0, 0, 0, 13, 100, NULL, 100, NULL, 1, '2016-04-15 06:43:12', NULL, NULL),
(120, '2016-04-15', 1, 0, 0, 0, 12, 100, NULL, 100, NULL, 1, '2016-04-15 06:44:02', NULL, NULL),
(121, '2016-04-15', 1, 0, 0, 0, 13, 100, NULL, 100, NULL, 1, '2016-04-15 06:44:03', NULL, NULL),
(122, '2016-04-15', 1, 0, 0, 0, 12, 100, NULL, 100, NULL, 1, '2016-04-15 06:45:49', NULL, NULL),
(123, '2016-04-15', 1, 0, 0, 0, 13, 100, NULL, 100, NULL, 1, '2016-04-15 06:45:49', NULL, NULL),
(124, '2016-04-15', 1, 0, 0, 0, 12, 10, NULL, 10, NULL, 1, '2016-04-15 06:55:46', NULL, NULL),
(125, '2016-04-15', 1, 0, 0, 0, 13, 10, NULL, 10, NULL, 1, '2016-04-15 06:55:46', NULL, NULL),
(126, '2016-04-07', 1, 0, 0, 0, 12, 10, NULL, 10, NULL, 1, '2016-04-15 06:57:07', NULL, NULL),
(127, '2016-04-07', 1, 0, 0, 0, 13, 10, NULL, 10, NULL, 1, '2016-04-15 06:57:07', NULL, NULL),
(128, '2016-04-15', 1, 0, 0, 0, 12, 10, NULL, 100, NULL, 1, '2016-04-15 07:05:07', NULL, NULL),
(129, '2016-04-15', 1, 0, 0, 0, 13, 10, NULL, 100, NULL, 1, '2016-04-15 07:05:07', NULL, NULL),
(130, '2016-04-07', 1, 0, 0, 0, 12, 10, NULL, 1200, NULL, 1, '2016-04-15 07:12:38', NULL, NULL),
(131, '2016-04-07', 1, 0, 0, 0, 13, 10, NULL, 120, NULL, 1, '2016-04-15 07:12:38', NULL, NULL),
(132, '2016-04-14', 1, 0, 0, 0, 12, 1, NULL, 150, NULL, 1, '2016-04-15 07:13:51', NULL, NULL),
(133, '2016-04-14', 1, 0, 0, 0, 13, 1, NULL, 1520, NULL, 1, '2016-04-15 07:13:51', NULL, NULL),
(134, '2016-04-14', 1, 0, 0, 0, 12, 1, NULL, 150, NULL, 1, '2016-04-15 07:13:52', NULL, NULL),
(135, '2016-04-14', 1, 0, 0, 0, 13, 1, NULL, 1520, NULL, 1, '2016-04-15 07:13:52', NULL, NULL),
(136, '2016-04-15', 1, 0, 0, 0, 12, 58, NULL, 1, NULL, 1, '2016-04-15 09:41:18', NULL, NULL),
(137, '2016-04-15', 1, 0, 0, 0, 13, 58, NULL, 1, NULL, 1, '2016-04-15 09:41:18', NULL, NULL),
(138, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 120, NULL, 1, '2016-04-15 09:42:36', NULL, NULL),
(139, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 120, NULL, 1, '2016-04-15 09:42:36', NULL, NULL),
(140, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 10, NULL, 1, '2016-04-15 09:45:41', NULL, NULL),
(141, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 10, NULL, 1, '2016-04-15 09:45:41', NULL, NULL),
(142, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 10, NULL, 1, '2016-04-15 09:47:05', NULL, NULL),
(143, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 10, NULL, 1, '2016-04-15 09:47:05', NULL, NULL),
(144, '2016-04-15', 1, 0, 0, 0, 4, NULL, 1, NULL, NULL, 1, '2016-04-15 09:59:37', NULL, NULL),
(145, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 10:07:16', NULL, NULL),
(146, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 10:07:16', NULL, NULL),
(147, '2016-04-15', 1, 0, 0, 0, 12, 96, NULL, 1, NULL, 1, '2016-04-15 11:17:51', NULL, NULL),
(148, '2016-04-15', 1, 0, 0, 0, 13, 96, NULL, 1, NULL, 1, '2016-04-15 11:17:51', NULL, NULL),
(149, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 11:23:13', NULL, NULL),
(150, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 11:23:13', NULL, NULL),
(151, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 11:36:26', NULL, NULL),
(152, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 11:36:26', NULL, NULL),
(153, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 11:38:21', NULL, NULL),
(154, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 11:38:21', NULL, NULL),
(155, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 11:39:23', NULL, NULL),
(156, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 11:39:23', NULL, NULL),
(157, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 11:40:24', NULL, NULL),
(158, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 11:40:24', NULL, NULL),
(159, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 11:41:41', NULL, NULL),
(160, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 11:41:41', NULL, NULL),
(161, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 11:54:07', NULL, NULL),
(162, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 11:54:07', NULL, NULL),
(163, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 12:58:40', NULL, NULL),
(164, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 12:58:40', NULL, NULL),
(165, '2016-04-13', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 13:01:04', NULL, NULL),
(166, '2016-04-13', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 13:01:04', NULL, NULL),
(167, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 13:02:27', NULL, NULL),
(168, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 13:02:27', NULL, NULL),
(169, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 13:04:15', NULL, NULL),
(170, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 13:04:15', NULL, NULL),
(171, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 13:19:26', NULL, NULL),
(172, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 13:19:26', NULL, NULL),
(173, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 13:54:04', NULL, NULL),
(174, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 13:54:04', NULL, NULL),
(175, '2016-04-15', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 13:58:07', NULL, NULL),
(176, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 13:58:07', NULL, NULL),
(177, '2016-04-14', 1, 0, 0, 0, 12, 1, NULL, 100, NULL, 1, '2016-04-15 14:01:54', NULL, NULL),
(178, '2016-04-14', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 14:01:54', NULL, NULL),
(179, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 14:41:31', NULL, NULL),
(180, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 14:49:37', NULL, NULL),
(181, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 14:50:31', NULL, NULL),
(182, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 14:51:18', NULL, NULL),
(183, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 14:52:04', NULL, NULL),
(184, '2016-04-15', 1, 0, 0, 0, 13, 1, NULL, 100, NULL, 1, '2016-04-15 14:52:10', NULL, NULL),
(185, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:02:21', NULL, NULL),
(186, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:03:15', NULL, NULL),
(187, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:03:45', NULL, NULL),
(188, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:04:28', NULL, NULL),
(189, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:06:34', NULL, NULL),
(190, '2016-04-14', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:08:07', NULL, NULL),
(191, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:11:20', NULL, NULL),
(192, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:37:05', NULL, NULL),
(193, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:51:45', NULL, NULL),
(194, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:55:03', NULL, NULL),
(195, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:57:01', NULL, NULL),
(196, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 15:59:29', NULL, NULL),
(197, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 16:01:35', NULL, NULL),
(198, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 16:18:36', NULL, NULL),
(199, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 16:22:59', NULL, NULL),
(200, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 16:25:44', NULL, NULL),
(201, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 16:31:14', NULL, NULL),
(202, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 16:52:44', NULL, NULL),
(203, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 17:31:51', NULL, NULL),
(204, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 17:35:50', NULL, NULL),
(205, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 17:40:19', NULL, NULL),
(206, '2016-04-15', 1, 0, 0, 0, 27, 1, NULL, 100, NULL, 1, '2016-04-15 17:43:03', NULL, NULL),
(207, '2016-04-25', 8, 0, 0, 0, 28, 50, NULL, 350, NULL, 1, '2016-04-25 16:04:18', NULL, NULL),
(208, '2016-04-25', 3, 0, 0, 0, 28, 1000, NULL, 1200, NULL, 1, '2016-04-25 16:25:01', NULL, NULL),
(209, '2016-04-26', 4, 0, 0, 0, 29, 1000, NULL, 10, NULL, 1, '2016-04-26 15:54:10', NULL, NULL),
(210, '2016-04-26', 4, 0, 0, 0, 29, 1000, NULL, 10, NULL, 1, '2016-04-26 15:54:10', NULL, NULL),
(211, '2016-04-26', 4, 0, 0, 0, 29, 500, NULL, 10, NULL, 1, '2016-04-27 15:03:00', NULL, NULL),
(212, '2016-04-26', 4, 0, 0, 0, 29, 500, NULL, 10, NULL, 1, '2016-04-27 15:03:00', NULL, NULL),
(213, '2016-04-26', 8, 0, 0, 0, 29, 10, NULL, 10, NULL, 1, '2016-04-27 15:10:58', NULL, NULL),
(214, '2016-04-26', 8, 0, 0, 0, 29, 10, NULL, 10, NULL, 1, '2016-04-27 15:10:59', NULL, NULL),
(215, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:13:23', NULL, NULL),
(216, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:13:23', NULL, NULL),
(217, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:19:06', NULL, NULL),
(218, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:19:07', NULL, NULL),
(219, '2016-04-27', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:22:20', NULL, NULL),
(220, '2016-04-27', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:22:20', NULL, NULL),
(221, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:45:04', NULL, NULL),
(222, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:45:05', NULL, NULL),
(223, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:49:51', NULL, NULL),
(224, '2016-04-26', 8, 0, 0, 0, 29, 4, NULL, 10, NULL, 1, '2016-04-27 15:49:51', NULL, NULL),
(225, '2016-04-26', 8, 0, 0, 0, 29, 9, NULL, 10, NULL, 1, '2016-04-27 16:01:20', NULL, NULL),
(226, '2016-04-26', 8, 0, 0, 0, 29, 9, NULL, 10, NULL, 1, '2016-04-27 16:01:21', NULL, NULL),
(227, '2016-04-29', 8, 0, 0, 0, 28, 50, NULL, 350, NULL, 1, '2016-04-29 21:33:30', NULL, NULL),
(228, '2016-04-29', 8, 0, 0, 0, 28, 50, NULL, 350, NULL, 1, '2016-04-29 21:33:30', NULL, NULL),
(229, '2016-04-29', 8, 0, 0, 0, 29, 1, NULL, 10, NULL, 1, '2016-04-30 08:01:14', NULL, NULL),
(230, '2016-04-29', 8, 0, 0, 0, 29, 1, NULL, 10, NULL, 1, '2016-04-30 08:01:15', NULL, NULL),
(231, '2016-04-29', 8, 0, 0, 0, 29, 7, NULL, 10, NULL, 1, '2016-04-30 08:02:33', NULL, NULL),
(232, '2016-04-29', 8, 0, 0, 0, 29, 7, NULL, 10, NULL, 1, '2016-04-30 08:02:33', NULL, NULL),
(233, '2016-04-29', 8, 0, 0, 0, 29, 1, NULL, 10, NULL, 1, '2016-04-30 20:06:11', NULL, NULL),
(234, '2016-04-29', 8, 0, 0, 0, 29, 1, NULL, 10, NULL, 1, '2016-04-30 20:06:12', NULL, NULL),
(235, '2016-04-29', 8, 0, 0, 0, 29, 1, NULL, 10, NULL, 1, '2016-04-30 20:08:05', NULL, NULL),
(236, '2016-04-29', 8, 0, 0, 0, 29, 1, NULL, 10, NULL, 1, '2016-04-30 20:08:06', NULL, NULL),
(237, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 20:13:36', NULL, NULL),
(238, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 20:13:37', NULL, NULL),
(239, '2016-04-30', 3, 0, 0, 0, 33, 4, NULL, 10, NULL, 1, '2016-04-30 20:17:13', NULL, NULL),
(240, '2016-04-30', 3, 0, 0, 0, 33, 4, NULL, 10, NULL, 1, '2016-04-30 20:17:14', NULL, NULL),
(241, '2016-04-29', 3, 0, 0, 0, 33, 6, NULL, 10, NULL, 1, '2016-04-30 20:35:46', NULL, NULL),
(242, '2016-04-29', 3, 0, 0, 0, 33, 6, NULL, 10, NULL, 1, '2016-04-30 20:35:46', NULL, NULL),
(243, '2016-04-30', 3, 0, 0, 0, 33, 5, NULL, 10, NULL, 1, '2016-04-30 20:37:28', NULL, NULL),
(244, '2016-04-30', 3, 0, 0, 0, 33, 5, NULL, 10, NULL, 1, '2016-04-30 20:37:28', NULL, NULL),
(245, '2016-04-29', 3, 0, 0, 0, 33, 8, NULL, 10, NULL, 1, '2016-04-30 20:38:26', NULL, NULL),
(246, '2016-04-29', 3, 0, 0, 0, 33, 8, NULL, 10, NULL, 1, '2016-04-30 20:38:26', NULL, NULL),
(247, '2016-04-29', 3, 0, 0, 0, 33, 6, NULL, 10, NULL, 1, '2016-04-30 20:40:06', NULL, NULL),
(248, '2016-04-29', 3, 0, 0, 0, 33, 6, NULL, 10, NULL, 1, '2016-04-30 20:40:06', NULL, NULL),
(249, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 10, NULL, 1, '2016-04-30 20:43:00', NULL, NULL),
(250, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 10, NULL, 1, '2016-04-30 20:43:01', NULL, NULL),
(251, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 10, NULL, 1, '2016-04-30 20:44:00', NULL, NULL),
(252, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 10, NULL, 1, '2016-04-30 20:44:00', NULL, NULL),
(253, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 10, NULL, 1, '2016-04-30 20:47:52', NULL, NULL),
(254, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 10, NULL, 1, '2016-04-30 20:47:52', NULL, NULL),
(255, '2016-04-29', 3, 0, 0, 0, 33, 4, NULL, 10, NULL, 1, '2016-04-30 20:50:27', NULL, NULL),
(256, '2016-04-29', 3, 0, 0, 0, 33, 4, NULL, 10, NULL, 1, '2016-04-30 20:50:27', NULL, NULL),
(257, '2016-04-29', 3, 0, 0, 0, 33, 5, NULL, 10, NULL, 1, '2016-04-30 20:51:36', NULL, NULL),
(258, '2016-04-29', 3, 0, 0, 0, 33, 5, NULL, 10, NULL, 1, '2016-04-30 20:51:37', NULL, NULL),
(259, '2016-04-30', 3, 0, 0, 0, 33, 2, NULL, 10, NULL, 1, '2016-04-30 21:05:35', NULL, NULL),
(260, '2016-04-30', 3, 0, 0, 0, 33, 2, NULL, 10, NULL, 1, '2016-04-30 21:05:36', NULL, NULL),
(261, '2016-04-29', 3, 0, 0, 0, 33, NULL, NULL, NULL, NULL, 1, '2016-04-30 21:06:52', NULL, NULL),
(262, '2016-04-29', 3, 0, 0, 0, 33, NULL, NULL, NULL, NULL, 1, '2016-04-30 21:06:53', NULL, NULL),
(263, '2016-04-29', 3, 0, 0, 0, 33, NULL, NULL, NULL, NULL, 1, '2016-04-30 21:08:43', NULL, NULL),
(264, '2016-04-29', 3, 0, 0, 0, 33, NULL, NULL, NULL, NULL, 1, '2016-04-30 21:08:43', NULL, NULL),
(265, NULL, 3, 0, 0, 0, 33, NULL, NULL, NULL, NULL, 1, '2016-04-30 21:10:24', NULL, NULL),
(266, NULL, 3, 0, 0, 0, 33, NULL, NULL, NULL, NULL, 1, '2016-04-30 21:10:24', NULL, NULL),
(267, '2016-04-29', 3, 0, 0, 0, 33, 9, NULL, 10, NULL, 1, '2016-04-30 21:16:22', NULL, NULL),
(268, '2016-04-29', 3, 0, 0, 0, 33, 9, NULL, 10, NULL, 1, '2016-04-30 21:16:22', NULL, NULL),
(269, '2016-04-29', 3, 0, 0, 0, 33, 7, NULL, 10, NULL, 1, '2016-04-30 21:19:22', NULL, NULL),
(270, '2016-04-29', 3, 0, 0, 0, 33, 7, NULL, 10, NULL, 1, '2016-04-30 21:19:23', NULL, NULL),
(271, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 21:22:12', NULL, NULL),
(272, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 21:22:12', NULL, NULL),
(273, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 22:17:16', NULL, NULL),
(274, '2016-04-30', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 22:29:51', NULL, NULL),
(275, '2016-04-30', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 22:31:01', NULL, NULL),
(276, '2016-04-30', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 22:33:27', NULL, NULL),
(277, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 23:13:22', NULL, NULL),
(278, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 10, NULL, 1, '2016-04-30 23:13:23', NULL, NULL),
(279, '2016-04-30', 8, 0, 0, 0, 29, 2, NULL, 10, NULL, 1, '2016-04-30 23:16:35', NULL, NULL),
(280, '2016-04-30', 8, 0, 0, 0, 29, 2, NULL, 10, NULL, 1, '2016-04-30 23:16:35', NULL, NULL),
(281, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 20, NULL, 1, '2016-05-01 05:55:02', NULL, NULL),
(282, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 20, NULL, 1, '2016-05-01 05:55:02', NULL, NULL),
(283, '2016-04-30', 3, 0, 0, 0, 33, 1, NULL, 20, NULL, 1, '2016-05-01 05:57:26', NULL, NULL),
(284, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 05:59:27', NULL, NULL),
(285, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 05:59:28', NULL, NULL),
(286, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:00:11', NULL, NULL),
(287, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:00:11', NULL, NULL),
(288, '2016-04-29', 3, 0, 0, 0, 33, 7, NULL, 20, NULL, 1, '2016-05-01 06:01:51', NULL, NULL),
(289, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:03:40', NULL, NULL),
(290, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:03:40', NULL, NULL),
(291, '2016-05-12', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 06:07:43', NULL, NULL),
(292, '2016-05-12', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 06:07:43', NULL, NULL),
(293, '2016-04-29', 3, 0, 0, 0, 33, 4, NULL, 20, NULL, 1, '2016-05-01 06:09:12', NULL, NULL),
(294, '2016-04-29', 3, 0, 0, 0, 33, 4, NULL, 20, NULL, 1, '2016-05-01 06:09:12', NULL, NULL),
(295, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:10:09', NULL, NULL),
(296, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 20, NULL, 1, '2016-05-01 06:17:27', NULL, NULL),
(297, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 20, NULL, 1, '2016-05-01 06:17:27', NULL, NULL),
(298, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:19:02', NULL, NULL),
(299, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:19:03', NULL, NULL),
(300, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 20, NULL, 1, '2016-05-01 06:21:00', NULL, NULL),
(301, '2016-04-29', 3, 0, 0, 0, 33, 1, NULL, 20, NULL, 1, '2016-05-01 06:21:00', NULL, NULL),
(302, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 06:22:07', NULL, NULL),
(303, '2016-04-29', 3, 0, 0, 0, 33, 5, NULL, 20, NULL, 1, '2016-05-01 06:23:14', NULL, NULL),
(304, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 06:23:49', NULL, NULL),
(305, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 06:23:49', NULL, NULL),
(306, '2016-04-29', 3, 0, 0, 0, 33, 3, NULL, 20, NULL, 1, '2016-05-01 06:24:26', NULL, NULL),
(307, '2016-04-29', 3, 0, 0, 0, 33, 4, NULL, 20, NULL, 1, '2016-05-01 06:25:35', NULL, NULL),
(308, '2016-04-29', 3, 0, 0, 0, 33, 2, NULL, 20, NULL, 1, '2016-05-01 06:26:28', NULL, NULL),
(309, '2016-04-29', 3, 0, 0, 0, 33, 4, NULL, 20, NULL, 1, '2016-05-01 06:28:18', NULL, NULL),
(310, '2016-04-29', 3, 0, 0, 0, 33, 5, NULL, 20, NULL, 1, '2016-05-01 06:28:47', NULL, NULL),
(311, '2016-04-29', 3, 5, 5, 0, 33, 25, NULL, 20, NULL, 1, '2016-05-01 08:16:48', NULL, NULL),
(312, '2016-04-29', 3, 5, 50, 0, 33, 250, NULL, 20, NULL, 1, '2016-05-09 11:47:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `cat` int(11) DEFAULT NULL,
  `cat_sub` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `store` int(11) NOT NULL,
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
  `vatable` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `cat`, `cat_sub`, `code`, `name`, `desc`, `unit`, `store`, `is_rawmat`, `supplier_id`, `pbrand`, `pmodel`, `country`, `grade`, `mfi`, `product_type`, `warn_qty`, `unit_convertable`, `vatable`) VALUES
(28, 7, 5, '00001', 'Basic', '', '1', 0, 1, 2, 1, 1, 45, 2, NULL, 3, 500, 0, 0),
(29, 7, 4, '00002', 'Basic', '', '1', 0, 0, 2, 1, 1, 19, 2, NULL, 3, 20, 0, 0),
(30, 7, 4, '00003', 'Goods', '', '1', 0, 1, 1, 1, 1, 19, 2, NULL, 4, 600, 0, 0),
(31, 7, 3, '00004', 'Sheet', '', '1', 0, 1, 1, 1, 1, 19, 2, NULL, 4, 30, 0, 0),
(32, 7, 5, '789', 'Sheet', '789', '1', 0, 0, 1, 1, 1, 19, 2, NULL, 4, NULL, 0, 0),
(33, 7, 2, '789', 'Sheet', '789', '1', 4, 0, 1, 1, 1, 19, 1, NULL, 3, NULL, 0, 0),
(34, 7, 2, '542', 'Basic', '789', '1', 4, 0, 2, 1, 1, 19, 1, NULL, 3, NULL, 0, 0),
(35, 7, 2, '789', 'Basic', '789', '1', 5, 0, 1, 1, 1, 19, 2, NULL, 3, NULL, 0, 0),
(36, 7, 1, '789', 'Basic', '789', '1', 7, 0, 2, NULL, 1, 19, 1, NULL, 3, 98, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lookup`
--

CREATE TABLE IF NOT EXISTS `lookup` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` int(10) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `type2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lookup`
--

INSERT INTO `lookup` (`id`, `name`, `code`, `type`, `type2`) VALUES
(43, 'ACTIVE', 1, 'is_active', NULL),
(44, 'INACTIVE', 2, 'is_active', NULL),
(45, 'VIRGIN', 3, 'product_type', NULL),
(46, 'RECYCLED', 4, 'product_type', NULL),
(47, 'SPOT PURCHASE', 5, 'order_sub_type', 'local'),
(48, 'QUATATION PURCHASE', 6, 'order_sub_type', 'local'),
(49, 'TENDER PURCHASE', 7, 'order_sub_type', 'local'),
(50, 'ETC', 8, 'order_sub_type', 'local'),
(51, 'LC under BOND', 9, 'order_sub_type', 'import'),
(52, 'LC under COMMERCIA', 10, 'order_sub_type', 'import'),
(53, 'LC under CAPITAL MACHINARY', 11, 'order_sub_type', 'import'),
(54, 'LC under SPARE PARTS', 12, 'order_sub_type', 'import'),
(55, 'LOCAL LC', 13, 'order_sub_type', 'import'),
(56, 'UNDER DIRECT PURCHASE', 14, 'order_sub_type', 'import'),
(57, 'PURCHASE under TT', 15, 'order_sub_type', 'import'),
(60, 'LOCAL', 16, 'order_type', NULL),
(61, 'IMPORT', 17, 'order_type', NULL),
(62, 'LOCAL', 18, 'order_type2', NULL),
(63, 'EXPORT', 19, 'order_type2', NULL),
(64, 'CASH', 20, 'received_type', NULL),
(65, 'CHEQUE', 21, 'received_type', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE IF NOT EXISTS `machines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`id`, `name`, `code`, `details`) VALUES
(1, 'asfd', '343', '');

-- --------------------------------------------------------

--
-- Table structure for table `machine_names`
--

CREATE TABLE IF NOT EXISTS `machine_names` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `machine_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `master_lc`
--

CREATE TABLE IF NOT EXISTS `master_lc` (
  `id` int(11) NOT NULL,
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
  `po_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `spouse` varchar(255) DEFAULT NULL,
  `card_no` varchar(255) DEFAULT NULL,
  `available_point` double DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `contact_no`, `email`, `address`, `dob`, `spouse`, `card_no`, `available_point`) VALUES
(1, 'Tanim', '01719062757', '', '', '0000-00-00', '', '01719062757', 15);

-- --------------------------------------------------------

--
-- Table structure for table `member_points`
--

CREATE TABLE IF NOT EXISTS `member_points` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `inv_no` varchar(255) DEFAULT NULL,
  `added_point` double DEFAULT NULL,
  `used_point` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `reduced_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_points`
--

INSERT INTO `member_points` (`id`, `member_id`, `inv_no`, `added_point`, `used_point`, `date`, `remarks`, `added_by`, `reduced_by`) VALUES
(1, 1, '201601271', 15, NULL, '2016-01-27', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member_points_conf`
--

CREATE TABLE IF NOT EXISTS `member_points_conf` (
  `id` int(11) NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `point_add_after_amount` double DEFAULT NULL,
  `point_add` double DEFAULT NULL,
  `over_amount` double DEFAULT NULL,
  `each_point_amount` double DEFAULT NULL,
  `usable_after_point` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_points_conf`
--

INSERT INTO `member_points_conf` (`id`, `is_active`, `start_date`, `end_date`, `point_add_after_amount`, `point_add`, `over_amount`, `each_point_amount`, `usable_after_point`) VALUES
(1, 2, '2016-01-25', '2016-02-29', 100, 1, 50, 1, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `mfis`
--

CREATE TABLE IF NOT EXISTS `mfis` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos`
--

CREATE TABLE IF NOT EXISTS `pos` (
  `id` int(11) NOT NULL,
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
  `is_recycled` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos`
--

INSERT INTO `pos` (`id`, `max_inv_no`, `inv_no`, `date`, `time`, `store_id`, `item_id`, `price`, `vatable_price`, `qty`, `discount`, `overall_discount`, `discount_type`, `cash_payment`, `visa_payment`, `master_payment`, `amex_payment`, `gift_card_payment`, `cash_return`, `initiated_by`, `authorized_by`, `machine_id`, `is_void`, `update_by`, `update_time`, `update_auth_by`, `month`, `year`, `void_auth_by`, `void_time`, `is_recycled`) VALUES
(1, 1, '201601251', '2016-01-25', '20:24:55', 1, 4, 250, 250, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(2, 1, '201601251', '2016-01-25', '20:24:55', 1, 7, 100, 100, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(3, 1, '201601251', '2016-01-25', '20:24:55', 1, 5, 100, 100, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(4, 1, '201601251', '2016-01-25', '20:24:55', 1, 6, 100, 100, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(5, 1, '201601251', '2016-01-25', '20:24:56', 1, 2, 150, 150, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(6, 1, '201601251', '2016-01-25', '20:24:56', 1, 1, 160, 160, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(7, 1, '201601251', '2016-01-25', '20:24:56', 1, 3, 100, 100, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(8, 1, '201601251', '2016-01-25', '20:24:56', 1, 8, 200, 200, 1, 0, 2, 1, 1136.8, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(9, 2, '201601252', '2016-01-25', '20:26:59', 1, 8, 200, 200, 2, 0, 20, 0, 380, 0, 0, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0),
(10, 1, '201601271', '2016-01-27', '19:43:57', 1, 4, 250, 250, 3, 0, 0, 0, 750, 0, 0, 0, 0, 0, 2, 1, NULL, 0, NULL, NULL, NULL, 01, 2016, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `production_input`
--

CREATE TABLE IF NOT EXISTS `production_input` (
  `id` int(11) NOT NULL,
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
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `production_input`
--

INSERT INTO `production_input` (`id`, `max_sl_no`, `sl_no`, `date`, `time`, `store`, `machine`, `track_no`, `item`, `qty`, `qty_kg`, `return_qty`, `return_qty_kg`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, 1, '343-201601241', '2016-01-24', '14:09:00', 1, 1, '', 4, 1, NULL, 0, 0, 1, '2016-01-24 14:09:40', 1, '2016-04-15 00:18:39'),
(2, 1, '343-201605091', '2016-05-09', '03:19:00', 6, 1, '', 36, 1, 15, 0, 0, 1, '2016-05-09 12:23:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `production_output`
--

CREATE TABLE IF NOT EXISTS `production_output` (
  `id` int(11) NOT NULL,
  `production_input_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `qty_kg` double DEFAULT NULL,
  `unit_of_distance` varchar(100) NOT NULL,
  `length` double NOT NULL,
  `width` double NOT NULL,
  `thickness` double NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `production_output`
--

INSERT INTO `production_output` (`id`, `production_input_no`, `max_sl_no`, `sl_no`, `date`, `time`, `item`, `qty`, `qty_kg`, `unit_of_distance`, `length`, `width`, `thickness`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, '343-201601241', 1, '343-201604161', '2016-04-16', '04:00:00', 24, 12, 12, '1', 12, 12, 12, 1, '2016-04-16 22:07:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `production_wastage`
--

CREATE TABLE IF NOT EXISTS `production_wastage` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `production_input_no` varchar(255) DEFAULT NULL,
  `wastage_qty` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `production_wastage`
--

INSERT INTO `production_wastage` (`id`, `date`, `production_input_no`, `wastage_qty`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, '2016-05-09', '343-201605091', 5, 1, '2016-05-09 12:24:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE IF NOT EXISTS `purchase_order` (
  `id` int(11) NOT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `purchase_order_by` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `ref_no` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `procurement_id` int(11) DEFAULT NULL,
  `procurement_no` varchar(255) DEFAULT NULL,
  `order_qty` double DEFAULT NULL,
  `cost` double NOT NULL,
  `subj` varchar(255) DEFAULT NULL,
  `is_verified` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `sl_no`, `purchase_order_by`, `approved_by`, `max_sl_no`, `ref_no`, `issue_date`, `procurement_id`, `procurement_no`, `order_qty`, `cost`, `subj`, `is_verified`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, '201601211', 0, 0, 1, '', '2016-01-21', 1, '201601211', 100000, 0, '', 1, 1, '2016-01-21 04:57:09', NULL, NULL),
(2, '201601211', 0, 0, 1, '', '2016-01-21', 2, '201601211', 100000, 0, '', 1, 1, '2016-01-21 04:57:09', NULL, NULL),
(3, '201603191', 0, 0, 1, '45', '2016-03-19', 3, '201603141', 5, 0, 'product', 1, 1, '2016-03-19 21:20:15', NULL, NULL),
(4, '201603192', 0, 0, 2, '45', '2016-03-19', 4, '201603191', 200, 0, 'product', 0, 1, '2016-03-19 23:22:13', NULL, NULL),
(5, '201603193', 0, 0, 3, '45', '2016-03-19', 5, '201603201', 100, 0, 'product', 1, 1, '2016-03-20 21:53:21', NULL, NULL),
(6, '201603193', 0, 0, 3, '45', '2016-03-19', 6, '201603201', 100, 0, 'product', 1, 1, '2016-03-20 21:53:21', NULL, NULL),
(7, '201603194', 0, 0, 4, '45', '2016-03-19', 4, '201603191', 550, 0, 'product', 0, 1, '2016-03-20 21:56:07', NULL, NULL),
(8, '201603195', 0, 0, 5, '45', '2016-03-19', 13, '201603206', 100, 0, 'product', 1, 1, '2016-03-21 00:13:00', NULL, NULL),
(9, '201603195', 0, 0, 5, '45', '2016-03-19', 14, '201603206', 100, 0, 'product', 1, 1, '2016-03-21 00:13:00', NULL, NULL),
(10, '201603211', 4, 1, 1, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:10:07', NULL, NULL),
(11, '201603211', 4, 1, 1, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:10:07', NULL, NULL),
(26, '201603219', 4, 1, 9, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:21', NULL, NULL),
(27, '201603219', 4, 1, 9, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:21', NULL, NULL),
(28, '2016032110', 4, 1, 10, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:22', NULL, NULL),
(29, '2016032110', 4, 1, 10, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:22', NULL, NULL),
(30, '2016032111', 4, 1, 11, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:23', NULL, NULL),
(31, '2016032111', 4, 1, 11, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:23', NULL, NULL),
(32, '2016032112', 4, 1, 12, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:24', NULL, NULL),
(33, '2016032112', 4, 1, 12, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:24', NULL, NULL),
(34, '2016032113', 4, 1, 13, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:26', NULL, NULL),
(35, '2016032113', 4, 1, 13, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:26', NULL, NULL),
(36, '2016032114', 4, 1, 14, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:26', NULL, NULL),
(37, '2016032114', 4, 1, 14, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:27', NULL, NULL),
(38, '2016032115', 4, 1, 15, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:27', NULL, NULL),
(39, '2016032115', 4, 1, 15, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:27', NULL, NULL),
(40, '2016032116', 4, 1, 16, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:28', NULL, NULL),
(41, '2016032116', 4, 1, 16, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:28', NULL, NULL),
(42, '2016032117', 4, 1, 17, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:29', NULL, NULL),
(43, '2016032117', 4, 1, 17, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:29', NULL, NULL),
(44, '2016032118', 4, 1, 18, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:30', NULL, NULL),
(45, '2016032118', 4, 1, 18, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:30', NULL, NULL),
(46, '2016032119', 4, 1, 19, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:31', NULL, NULL),
(47, '2016032119', 4, 1, 19, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:31', NULL, NULL),
(48, '2016032120', 4, 1, 20, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:32', NULL, NULL),
(49, '2016032120', 4, 1, 20, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:32', NULL, NULL),
(50, '2016032121', 4, 1, 21, '45', '2016-03-21', 11, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:33', NULL, NULL),
(51, '2016032121', 4, 1, 21, '45', '2016-03-21', 12, '201603205', 100, 0, NULL, 1, 1, '2016-03-21 08:21:33', NULL, NULL),
(52, '2016032122', 0, 0, 22, '45', '2016-03-21', 10, '201603204', 50, 0, NULL, 1, 1, '2016-03-21 08:28:50', NULL, NULL),
(53, '2016032122', 0, 0, 22, '45', '2016-03-21', 9, '201603203', 100, 0, NULL, 1, 1, '2016-03-21 08:28:50', NULL, NULL),
(54, '2016032123', 0, 0, 23, '45', '2016-03-21', 7, '201603202', 20, 0, NULL, 1, 1, '2016-03-21 08:30:26', NULL, NULL),
(55, '2016032123', 0, 0, 23, '45', '2016-03-21', 8, '201603202', 200, 0, NULL, 1, 1, '2016-03-21 08:30:27', NULL, NULL),
(56, '201603141', 4, 1, 1, '45', '2016-03-14', 7, '201603202', 50, 0, NULL, 1, 1, '2016-03-21 08:35:22', NULL, NULL),
(57, '2016032124', 4, 1, 24, '45', '2016-03-21', 7, '201603202', 50, 0, NULL, 1, 1, '2016-03-21 08:38:41', NULL, NULL),
(58, '2016032125', 4, 1, 25, '45', '2016-03-21', 4, '201603191', 550, 0, NULL, 0, 1, '2016-03-21 08:41:03', NULL, NULL),
(59, '2016032126', 4, 1, 26, '45', '2016-03-21', 4, '201603191', 50, 0, NULL, 0, 1, '2016-03-21 08:43:55', NULL, NULL),
(60, '201603221', 3, 3, 1, '45', '2016-03-22', 15, '201603221', 20, 0, NULL, 1, 1, '2016-03-22 18:25:26', NULL, NULL),
(61, '201603221', 3, 3, 1, '45', '2016-03-22', 16, '201603221', 100, 0, NULL, 1, 1, '2016-03-22 18:25:26', NULL, NULL),
(62, '201603222', 3, 3, 2, '123', '2016-03-22', 4, '201603191', 100, 55, NULL, 0, 1, '2016-03-22 20:19:08', NULL, NULL),
(63, '201603223', 3, 3, 3, '45', '2016-03-22', 4, '201603191', 100, 50, NULL, 0, 1, '2016-03-22 20:51:54', NULL, NULL),
(64, '201603224', 3, 3, 4, '123', '2016-03-22', 4, '201603191', 20, 10, NULL, 0, 1, '2016-03-22 20:54:34', NULL, NULL),
(65, '201603225', 3, 3, 5, '123', '2016-03-22', 4, '201603191', 100, 50, NULL, 0, 1, '2016-03-22 20:56:49', NULL, NULL),
(66, '2016032127', 3, 3, 27, '45', '2016-03-21', 4, '201603191', 200, 25, NULL, 0, 1, '2016-03-22 21:13:53', NULL, NULL),
(67, '201603241', 0, 0, 1, '11', '2016-03-24', 4, '201603191', 981, 0, 'product', 0, 1, '2016-03-24 06:34:54', NULL, NULL),
(68, '201604141', 1, 1, 1, '', '2016-04-14', 17, '201603241', 1111, 20, NULL, 0, 1, '2016-04-14 22:35:57', NULL, NULL),
(69, '201604141', 1, 1, 1, '', '2016-04-14', 4, '201603191', 97149, 550, NULL, 0, 1, '2016-04-14 22:35:57', NULL, NULL),
(70, '201604151', 1, 1, 1, '2343', '2016-04-15', 18, '201604151', 15, 100, NULL, 1, 1, '2016-04-15 11:22:32', NULL, NULL),
(71, '201604151', 1, 1, 1, '2343', '2016-04-15', 19, '201604151', 20, 100, NULL, 1, 1, '2016-04-15 11:22:33', NULL, NULL),
(72, '201604152', 1, 1, 2, '2343', '2016-04-15', 21, '201604153', 1, 100, NULL, 1, 1, '2016-04-15 14:57:20', NULL, NULL),
(73, '201604153', 1, 1, 3, '2343', '2016-04-15', 22, '201604154', 101, 100, NULL, 1, 1, '2016-04-15 15:00:01', NULL, NULL),
(74, '201604154', 1, 1, 4, '2343', '2016-04-15', 23, '201604155', 1, 100, NULL, 1, 1, '2016-04-15 15:44:50', NULL, NULL),
(75, '201604251', 11, 12, 1, '', '2016-04-25', 24, '201604251', 50, 350, NULL, 1, 1, '2016-04-25 15:59:36', NULL, NULL),
(76, '201604271', 11, 12, 1, 'fsd', '2016-04-27', 25, '201604261', 1000, 10, NULL, 1, 1, '2016-04-26 14:47:53', NULL, NULL),
(77, '201604261', 12, 12, 1, '100', '2016-04-26', 26, '201604262', 100, 10, NULL, 1, 1, '2016-04-26 17:07:08', NULL, NULL),
(78, '201604301', 11, 12, 1, '125', '2016-04-30', 28, '201604301', 100, 10, NULL, 1, 1, '2016-04-30 20:13:08', NULL, NULL),
(79, '201604302', 11, 12, 2, '125', '2016-04-30', 29, '201604302', 10000, 20, NULL, 1, 1, '2016-04-30 23:18:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_procurement`
--

CREATE TABLE IF NOT EXISTS `purchase_procurement` (
  `id` int(11) NOT NULL,
  `req_id` int(11) DEFAULT NULL,
  `req_no` varchar(255) DEFAULT NULL,
  `procurement_by` int(11) NOT NULL,
  `approve_to` int(11) NOT NULL,
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
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_procurement`
--

INSERT INTO `purchase_procurement` (`id`, `req_id`, `req_no`, `procurement_by`, `approve_to`, `sl_no`, `max_sl_no`, `date`, `store`, `item`, `supplier_id`, `order_type`, `order_sub_type`, `department`, `qty`, `cost`, `remarks`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, 1, '201601211', 0, 0, '201601211', 1, '2016-01-21', 1, 1, 1, 16, 5, 1, 100000, 550, '', 1, '2016-01-21 04:56:52', NULL, NULL),
(2, 2, '201601211', 0, 0, '201601211', 1, '2016-01-21', 1, 2, 1, 16, 5, 1, 100000, 550, '', 1, '2016-01-21 04:56:52', NULL, NULL),
(3, 7, '201603141', 0, 0, '201603141', 1, '2016-03-14', 1, 14, 2, 16, 5, 1, 5, 100, 'Urgent', 1, '2016-03-14 10:22:07', NULL, NULL),
(4, 3, '201601211', 0, 0, '201603191', 1, '2016-03-19', 1, 3, 2, 17, 13, 1, 100000, 550, '', 1, '2016-03-19 21:28:15', NULL, NULL),
(5, 38, '201603206', 0, 0, '201603201', 1, '2016-03-20', 1, 12, 1, 16, 5, 2, 15, 100, 'Urgent', 1, '2016-03-20 21:52:06', NULL, NULL),
(6, 39, '201603206', 0, 0, '201603201', 1, '2016-03-20', 1, 13, 1, 16, 5, 2, 20, 100, 'Urgent', 1, '2016-03-20 21:52:06', NULL, NULL),
(7, NULL, '201603206', 4, 1, '201603202', 2, '2016-03-20', 1, 12, 1, 16, 5, 2, 100, 50, '', 1, '2016-03-20 23:46:16', NULL, NULL),
(8, NULL, '201603206', 4, 1, '201603202', 2, '2016-03-20', 1, 14, 1, 16, 5, 2, 100, 50, '', 1, '2016-03-20 23:46:17', NULL, NULL),
(9, NULL, '201603206', 4, 1, '201603203', 3, '2016-03-20', 1, 12, 1, 16, 5, 2, 1, 100, '', 1, '2016-03-20 23:47:43', NULL, NULL),
(10, 4, '201601251', 4, 1, '201603204', 4, '2016-03-20', 1, 2, 1, 16, 5, 1, 6, 50, '', 1, '2016-03-20 23:48:23', NULL, NULL),
(11, 30, '201603202', 4, 1, '201603205', 5, '2016-03-20', 1, 12, 1, 16, 5, 2, 15, 100, 'Urgent', 1, '2016-03-20 23:49:07', NULL, NULL),
(12, 31, '201603202', 4, 1, '201603205', 5, '2016-03-20', 1, 13, 1, 16, 5, 2, 20, 100, 'Urgent', 1, '2016-03-20 23:49:07', NULL, NULL),
(13, 34, '201603206', 4, 1, '201603206', 6, '2016-03-20', 1, 12, 1, 16, 5, 2, 30, 100, 'Urgent', 1, '2016-03-20 23:51:10', 1, '2016-03-21 00:11:45'),
(14, 35, '201603206', 4, 1, '201603206', 6, '2016-03-20', 1, 13, 1, 16, 5, 2, 20, 100, 'Urgent', 1, '2016-03-20 23:51:10', 1, '2016-03-21 00:11:45'),
(15, 40, '201603221', 3, 3, '201603221', 1, '2016-03-22', 1, 7, 2, 16, 5, 1, 10, 20, 'Test', 1, '2016-03-22 18:21:22', NULL, NULL),
(16, 41, '201603221', 3, 3, '201603221', 1, '2016-03-22', 1, 5, 2, 16, 5, 1, 100, 100, 'Test', 1, '2016-03-22 18:21:23', NULL, NULL),
(17, NULL, '201603221', 0, 0, '201603241', 1, '2016-03-24', 1, 9, 2, 17, 9, 1, 1111, 20, '', 1, '2016-03-24 07:15:44', NULL, NULL),
(18, 36, '201603205', 1, 1, '201604151', 1, '2016-04-15', 1, 12, 2, 16, 5, 2, 15, 100, 'Urgent', 1, '2016-04-15 11:21:43', NULL, NULL),
(19, 37, '201603205', 1, 1, '201604151', 1, '2016-04-15', 1, 13, 2, 16, 5, 2, 20, 100, 'Urgent', 1, '2016-04-15 11:21:44', NULL, NULL),
(20, 16, '201603188', 1, 1, '201604152', 2, '2016-04-15', 1, 1, 2, 16, 5, 1, 1, 100, '', 1, '2016-04-15 14:56:02', NULL, NULL),
(21, 12, '201603184', 4, 1, '201604153', 3, '2016-04-15', 1, 27, 1, 16, 5, 1, 1, 100, '', 1, '2016-04-15 14:56:44', NULL, NULL),
(22, 10, '201603182', 1, 1, '201604154', 4, '2016-04-15', 1, 27, 2, 16, 5, 1, 101, 100, '', 1, '2016-04-15 14:59:32', NULL, NULL),
(23, 14, '201603186', 1, 1, '201604155', 5, '2016-04-15', 2, 9, 1, 16, 5, 1, 1, 100, '', 1, '2016-04-15 15:44:27', NULL, NULL),
(24, 42, '201604251', 11, 12, '201604251', 1, '2016-04-25', 8, 28, 2, 16, 5, 3, 50, 350, '', 1, '2016-04-25 15:59:09', NULL, NULL),
(25, 43, '201604261', 11, 12, '201604261', 1, '2016-04-26', 4, 29, 1, 16, 5, 1, 1000, 10, 'Argent', 1, '2016-04-26 14:47:02', NULL, NULL),
(26, 44, '201604262', 12, 12, '201604262', 2, '2016-04-26', 8, 29, 2, 16, 5, 1, 100, 10, '', 1, '2016-04-26 17:06:32', NULL, NULL),
(27, 45, '201604271', 11, 12, '201604271', 1, '2016-04-27', 3, 28, 2, 16, 5, 1, 100, 10, '', 1, '2016-04-27 14:12:26', NULL, NULL),
(28, 47, '201604301', 12, 12, '201604301', 1, '2016-04-30', 3, 33, 2, 16, 5, 1, 100, 10, '', 1, '2016-04-30 20:12:34', NULL, NULL),
(29, 48, '201604302', 12, 12, '201604302', 2, '2016-04-30', 3, 33, 1, 16, 5, 1, 10000, 20, '', 1, '2016-04-30 23:18:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_rcv_rtn`
--

CREATE TABLE IF NOT EXISTS `purchase_rcv_rtn` (
  `id` int(11) NOT NULL,
  `challan_no` varchar(255) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `supplier_id` varchar(11) DEFAULT NULL,
  `rcv_date` date DEFAULT NULL,
  `noOfReceivedSack` int(11) NOT NULL,
  `weightPerSack` int(11) NOT NULL,
  `rcv_qty` double DEFAULT NULL,
  `received_by` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `rtn_date` date DEFAULT NULL,
  `store` varchar(100) NOT NULL,
  `rtn_qty` double DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `remarks_for_rcv` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `return_by` int(11) DEFAULT NULL,
  `return_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_rcv_rtn`
--

INSERT INTO `purchase_rcv_rtn` (`id`, `challan_no`, `po_id`, `supplier_id`, `rcv_date`, `noOfReceivedSack`, `weightPerSack`, `rcv_qty`, `received_by`, `approved_by`, `rtn_date`, `store`, `rtn_qty`, `cost`, `remarks_for_rcv`, `remarks`, `created_by`, `created_time`, `updated_by`, `updated_time`, `return_by`, `return_time`) VALUES
(3, '112233', 1, '1', '2016-01-23', 0, 0, 100000, 0, 0, NULL, '', NULL, 550, '', NULL, 1, '2016-01-23 22:30:18', NULL, NULL, NULL, NULL),
(4, '112233', 2, '1', '2016-01-23', 0, 0, 100000, 0, 0, NULL, '', NULL, 550, '', NULL, 1, '2016-01-23 22:30:18', NULL, NULL, NULL, NULL),
(5, '25', 26, '1', '0000-00-00', 0, 0, 10, 0, 0, NULL, '', NULL, 100, 'Need', NULL, 1, '2016-03-21 08:49:40', NULL, NULL, NULL, NULL),
(6, '25', 27, '1', '0000-00-00', 0, 0, 10, 0, 0, NULL, '', NULL, 100, 'Need', NULL, 1, '2016-03-21 08:49:40', NULL, NULL, NULL, NULL),
(7, '25', 60, '2', '2016-03-22', 0, 0, 10, 0, 0, NULL, '', NULL, 20, '', NULL, 1, '2016-03-22 18:28:29', NULL, NULL, NULL, NULL),
(8, '25', 61, '2', '2016-03-22', 0, 0, 50, 0, 0, NULL, '', NULL, 100, '', NULL, 1, '2016-03-22 18:28:29', NULL, NULL, NULL, NULL),
(9, '25', 60, '2', '2016-03-15', 0, 0, 10, 3, 3, NULL, '', NULL, 100, '', NULL, 1, '2016-03-22 22:33:13', NULL, NULL, NULL, NULL),
(10, '25', 61, '2', '2016-03-15', 0, 0, 50, 3, 3, NULL, '', NULL, 100, '', NULL, 1, '2016-03-22 22:33:13', NULL, NULL, NULL, NULL),
(11, '121', 57, '1', '2016-04-13', 0, 0, 50, 1, 1, NULL, '', NULL, 1254, 'good', NULL, 1, '2016-04-13 21:20:50', NULL, NULL, NULL, NULL),
(12, '120', 56, '1', '2016-04-14', 0, 0, 50, 1, 1, NULL, '', NULL, 200, 'need urgent', NULL, 1, '2016-04-14 05:52:07', NULL, NULL, NULL, NULL),
(13, '120', 10, '1', '2016-04-07', 0, 0, 100, 1, 1, NULL, '', NULL, 110, 'sds', NULL, 1, '2016-04-14 06:13:44', NULL, NULL, NULL, NULL),
(14, '120', 11, '1', '2016-04-07', 0, 0, 100, 1, 1, NULL, '', NULL, 110, 'ddsds', NULL, 1, '2016-04-14 06:13:44', NULL, NULL, NULL, NULL),
(15, '120', 10, '1', '2016-04-07', 0, 0, 100, 1, 1, NULL, '', NULL, 110, 'sds', NULL, 1, '2016-04-14 06:13:44', NULL, NULL, NULL, NULL),
(16, '120', 11, '1', '2016-04-07', 0, 0, 100, 1, 1, NULL, '', NULL, 110, 'ddsds', NULL, 1, '2016-04-14 06:13:44', NULL, NULL, NULL, NULL),
(17, '120', 28, '1', '2016-04-14', 0, 0, 100, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-14 07:27:25', NULL, NULL, NULL, NULL),
(18, '120', 29, '1', '2016-04-14', 0, 0, 100, 1, 1, NULL, '', NULL, 100, 'ddsds', NULL, 1, '2016-04-14 07:27:25', NULL, NULL, NULL, NULL),
(19, '120', 26, '1', '2016-04-07', 0, 0, 90, 1, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-14 07:39:59', NULL, NULL, NULL, NULL),
(20, '120', 27, '1', '2016-04-07', 0, 0, 90, 1, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-14 07:40:00', NULL, NULL, NULL, NULL),
(21, '120', 54, '1', '2016-04-07', 0, 0, 20, 1, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-14 07:54:29', NULL, NULL, NULL, NULL),
(22, '120', 55, '1', '2016-04-07', 0, 0, 200, 1, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-14 07:54:29', NULL, NULL, NULL, NULL),
(23, '120', 50, '1', '2016-04-07', 0, 0, 100, 1, 1, NULL, '', NULL, 1200, 'need urgent', NULL, 1, '2016-04-14 08:00:26', NULL, NULL, NULL, NULL),
(24, '120', 51, '1', '2016-04-07', 0, 0, 100, 1, 1, NULL, '', NULL, 1200, 'need urgent', NULL, 1, '2016-04-14 08:00:26', NULL, NULL, NULL, NULL),
(25, '120', 3, '2', '2016-04-14', 0, 0, 5, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-14 22:32:09', NULL, NULL, NULL, NULL),
(26, '120', 8, '1', '2016-04-06', 0, 0, 100, 1, 1, NULL, '', NULL, 4150, 'need urgent', NULL, 1, '2016-04-14 22:34:37', NULL, NULL, NULL, NULL),
(27, '120', 9, '1', '2016-04-06', 0, 0, 100, 1, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-14 22:34:37', NULL, NULL, NULL, NULL),
(28, '120', 46, '1', '2016-04-13', 0, 0, 100, 4, 1, NULL, '', NULL, 123, 'need urgent', NULL, 1, '2016-04-15 00:05:55', NULL, NULL, NULL, NULL),
(29, '120', 47, '1', '2016-04-13', 0, 0, 100, 4, 1, '2016-04-15', '', 12, 123, 'need urgent', 'bd', 1, '2016-04-15 00:05:55', NULL, NULL, 1, '2016-04-15 00:19:26'),
(30, '120', 38, '1', '2016-04-13', 0, 0, 100, 1, 4, NULL, '', NULL, 1230, 'need urgent', NULL, 1, '2016-04-15 00:08:51', NULL, NULL, NULL, NULL),
(31, '120', 39, '1', '2016-04-13', 0, 0, 100, 1, 4, NULL, '', NULL, 123, 'need urgent', NULL, 1, '2016-04-15 00:08:51', NULL, NULL, NULL, NULL),
(32, '120', 47, '1', '2016-04-14', 0, 0, 12, 1, 1, NULL, '', NULL, 12, 'need urgent', NULL, 1, '2016-04-15 00:20:52', NULL, NULL, NULL, NULL),
(33, '120', 52, '1', '2016-04-15', 0, 0, 50, 1, 1, NULL, '', NULL, 12, 'need urgent', NULL, 1, '2016-04-15 00:57:21', NULL, NULL, NULL, NULL),
(34, '120', 53, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 123, 'need urgent', NULL, 1, '2016-04-15 00:57:21', NULL, NULL, NULL, NULL),
(35, '120', 44, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 123, 'need urgent', NULL, 1, '2016-04-15 01:04:20', NULL, NULL, NULL, NULL),
(36, '120', 45, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 34, 'need urgent', NULL, 1, '2016-04-15 01:04:20', NULL, NULL, NULL, NULL),
(37, '120', 40, '1', '2016-04-07', 0, 0, 100, 4, 1, NULL, '', NULL, 123, 'need urgent', NULL, 1, '2016-04-15 01:08:18', NULL, NULL, NULL, NULL),
(38, '120', 41, '1', '2016-04-07', 0, 0, 100, 4, 1, NULL, '', NULL, 345, 'need urgent', NULL, 1, '2016-04-15 01:08:18', NULL, NULL, NULL, NULL),
(39, '120', 42, '1', '2016-04-06', 0, 0, 100, 4, 1, NULL, '', NULL, 123, 'need urgent', NULL, 1, '2016-04-15 06:35:21', NULL, NULL, NULL, NULL),
(40, '120', 43, '1', '2016-04-06', 0, 0, 100, 4, 1, NULL, '', NULL, 125, 'need urgent', NULL, 1, '2016-04-15 06:35:21', NULL, NULL, NULL, NULL),
(41, '120', 30, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 67, 'need urgent', NULL, 1, '2016-04-15 06:35:57', NULL, NULL, NULL, NULL),
(42, '120', 31, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 87, 'need urgent', NULL, 1, '2016-04-15 06:35:57', NULL, NULL, NULL, NULL),
(43, '120', 48, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 120, 'ddsds', NULL, 1, '2016-04-15 06:43:12', NULL, NULL, NULL, NULL),
(44, '120', 49, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 06:43:12', NULL, NULL, NULL, NULL),
(45, '120', 5, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 06:44:02', NULL, NULL, NULL, NULL),
(46, '120', 6, '1', '2016-04-15', 0, 0, 100, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 06:44:02', NULL, NULL, NULL, NULL),
(47, '120', 34, '1', '2016-04-15', 0, 0, 100, 4, 4, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 06:45:49', NULL, NULL, NULL, NULL),
(48, '120', 35, '1', '2016-04-15', 0, 0, 100, 4, 4, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 06:45:49', NULL, NULL, NULL, NULL),
(49, '120', 32, '1', '2016-04-15', 0, 0, 10, 1, 4, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 06:55:46', NULL, NULL, NULL, NULL),
(50, '120', 33, '1', '2016-04-15', 0, 0, 10, 1, 4, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 06:55:46', NULL, NULL, NULL, NULL),
(51, '120', 32, '1', '2016-04-07', 0, 0, 10, 1, 1, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 06:57:07', NULL, NULL, NULL, NULL),
(52, '120', 33, '1', '2016-04-07', 0, 0, 10, 1, 1, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 06:57:07', NULL, NULL, NULL, NULL),
(53, '120', 32, '1', '2016-04-15', 0, 0, 10, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 07:05:07', NULL, NULL, NULL, NULL),
(54, '120', 33, '1', '2016-04-15', 0, 0, 10, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 07:05:07', NULL, NULL, NULL, NULL),
(55, '120', 32, '1', '2016-04-07', 0, 0, 10, 4, 1, NULL, '', NULL, 1200, 'need urgent', NULL, 1, '2016-04-15 07:12:38', NULL, NULL, NULL, NULL),
(56, '120', 33, '1', '2016-04-07', 0, 0, 10, 4, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-15 07:12:38', NULL, NULL, NULL, NULL),
(57, '120', 32, '1', '2016-04-14', 0, 0, 1, 1, 1, NULL, '', NULL, 150, 'need urgent', NULL, 1, '2016-04-15 07:13:50', NULL, NULL, NULL, NULL),
(58, '120', 33, '1', '2016-04-14', 0, 0, 1, 1, 1, NULL, '', NULL, 1520, 'need urgent', NULL, 1, '2016-04-15 07:13:51', NULL, NULL, NULL, NULL),
(59, '120', 32, '1', '2016-04-14', 0, 0, 1, 1, 1, NULL, '', NULL, 150, 'need urgent', NULL, 1, '2016-04-15 07:13:52', NULL, NULL, NULL, NULL),
(60, '120', 33, '1', '2016-04-14', 0, 0, 1, 1, 1, NULL, '', NULL, 1520, 'need urgent', NULL, 1, '2016-04-15 07:13:52', NULL, NULL, NULL, NULL),
(61, '120', 32, '1', '2016-04-15', 0, 0, 58, 1, 1, NULL, '', NULL, 1, 'need urgent', NULL, 1, '2016-04-15 09:41:18', NULL, NULL, NULL, NULL),
(62, '120', 33, '1', '2016-04-15', 0, 0, 58, 1, 1, NULL, '', NULL, 1, 'need urgent', NULL, 1, '2016-04-15 09:41:18', NULL, NULL, NULL, NULL),
(63, '120', 36, '1', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-15 09:42:36', NULL, NULL, NULL, NULL),
(64, '120', 37, '1', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 120, 'need urgent', NULL, 1, '2016-04-15 09:42:36', NULL, NULL, NULL, NULL),
(65, '120', 36, '1', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 09:45:41', NULL, NULL, NULL, NULL),
(66, '120', 37, '1', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 09:45:41', NULL, NULL, NULL, NULL),
(67, '120', 36, '1', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 09:47:05', NULL, NULL, NULL, NULL),
(68, '120', 37, '1', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 10, 'need urgent', NULL, 1, '2016-04-15 09:47:05', NULL, NULL, NULL, NULL),
(69, '120', 36, '1', '2016-04-15', 0, 0, 1, 1, 4, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 10:07:16', NULL, NULL, NULL, NULL),
(70, '120', 37, '1', '2016-04-15', 0, 0, 1, 1, 4, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 10:07:16', NULL, NULL, NULL, NULL),
(71, '120', 36, '1', '2016-04-15', 0, 0, 96, 1, 1, NULL, '', NULL, 1, 'need urgent', NULL, 1, '2016-04-15 11:17:51', NULL, NULL, NULL, NULL),
(72, '120', 37, '1', '2016-04-15', 0, 0, 96, 1, 1, NULL, '', NULL, 1, 'need urgent', NULL, 1, '2016-04-15 11:17:51', NULL, NULL, NULL, NULL),
(73, '90', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:23:13', NULL, NULL, NULL, NULL),
(74, '90', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:23:13', NULL, NULL, NULL, NULL),
(75, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:36:26', NULL, NULL, NULL, NULL),
(76, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:36:26', NULL, NULL, NULL, NULL),
(77, '90', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:38:21', NULL, NULL, NULL, NULL),
(78, '90', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:38:21', NULL, NULL, NULL, NULL),
(79, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:39:23', NULL, NULL, NULL, NULL),
(80, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:39:23', NULL, NULL, NULL, NULL),
(81, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'ddsds', NULL, 1, '2016-04-15 11:40:24', NULL, NULL, NULL, NULL),
(82, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:40:24', NULL, NULL, NULL, NULL),
(83, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 11:41:41', NULL, NULL, NULL, NULL),
(84, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 11:41:41', NULL, NULL, NULL, NULL),
(85, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:54:07', NULL, NULL, NULL, NULL),
(86, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 11:54:07', NULL, NULL, NULL, NULL),
(87, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 12:58:40', NULL, NULL, NULL, NULL),
(88, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 12:58:40', NULL, NULL, NULL, NULL),
(89, '120', 70, '2', '2016-04-13', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 13:01:04', NULL, NULL, NULL, NULL),
(90, '120', 71, '2', '2016-04-13', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 13:01:04', NULL, NULL, NULL, NULL),
(91, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:02:27', NULL, NULL, NULL, NULL),
(92, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:02:27', NULL, NULL, NULL, NULL),
(93, '90', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:04:15', NULL, NULL, NULL, NULL),
(94, '90', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:04:15', NULL, NULL, NULL, NULL),
(95, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:19:26', NULL, NULL, NULL, NULL),
(96, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:19:26', NULL, NULL, NULL, NULL),
(97, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 13:54:03', NULL, NULL, NULL, NULL),
(98, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 13:54:04', NULL, NULL, NULL, NULL),
(99, '120', 70, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:58:07', NULL, NULL, NULL, NULL),
(100, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 13:58:07', NULL, NULL, NULL, NULL),
(101, '120', 70, '2', '2016-04-14', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 14:01:54', NULL, NULL, NULL, NULL),
(102, '120', 71, '2', '2016-04-14', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 14:01:54', NULL, NULL, NULL, NULL),
(103, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 14:41:31', NULL, NULL, NULL, NULL),
(104, '90', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 14:49:37', NULL, NULL, NULL, NULL),
(105, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 14:50:31', NULL, NULL, NULL, NULL),
(106, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 14:51:18', NULL, NULL, NULL, NULL),
(107, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 14:52:04', NULL, NULL, NULL, NULL),
(108, '120', 71, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 14:52:10', NULL, NULL, NULL, NULL),
(109, '90', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, 'need urgent', NULL, 1, '2016-04-15 15:02:21', NULL, NULL, NULL, NULL),
(110, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:03:14', NULL, NULL, NULL, NULL),
(111, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:03:45', NULL, NULL, NULL, NULL),
(112, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:04:28', NULL, NULL, NULL, NULL),
(113, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:06:34', NULL, NULL, NULL, NULL),
(114, '120', 73, '2', '2016-04-14', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:08:07', NULL, NULL, NULL, NULL),
(115, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:11:20', NULL, NULL, NULL, NULL),
(116, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:37:05', NULL, NULL, NULL, NULL),
(117, '', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:51:45', NULL, NULL, NULL, NULL),
(118, '90', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:55:03', NULL, NULL, NULL, NULL),
(119, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:57:00', NULL, NULL, NULL, NULL),
(120, '90', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 15:59:29', NULL, NULL, NULL, NULL),
(121, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 16:01:35', NULL, NULL, NULL, NULL),
(122, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 16:18:36', NULL, NULL, NULL, NULL),
(123, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 16:22:58', NULL, NULL, NULL, NULL),
(124, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 16:25:44', NULL, NULL, NULL, NULL),
(125, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 16:31:14', NULL, NULL, NULL, NULL),
(126, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 16:52:44', NULL, NULL, NULL, NULL),
(127, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 17:31:51', NULL, NULL, NULL, NULL),
(128, '90', 73, '2', '2016-04-15', 0, 0, 1, 4, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 17:35:49', NULL, NULL, NULL, NULL),
(129, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 17:40:18', NULL, NULL, NULL, NULL),
(130, '120', 73, '2', '2016-04-15', 0, 0, 1, 1, 1, NULL, '', NULL, 100, '', NULL, 1, '2016-04-15 17:43:03', NULL, NULL, NULL, NULL),
(131, '123', 76, '1', '2016-04-26', 5, 100, 500, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:02:59', NULL, NULL, NULL, NULL),
(132, '123', 76, '1', '2016-04-26', 5, 100, 500, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:03:00', NULL, NULL, NULL, NULL),
(133, '123', 77, '2', '2016-04-26', 2, 5, 10, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:10:58', NULL, NULL, NULL, NULL),
(134, '123', 77, '2', '2016-04-26', 2, 5, 10, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:10:59', NULL, NULL, NULL, NULL),
(135, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:13:23', NULL, NULL, NULL, NULL),
(136, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:13:23', NULL, NULL, NULL, NULL),
(137, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, 'Urgent', NULL, 1, '2016-04-27 15:19:06', NULL, NULL, NULL, NULL),
(138, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, 'Urgent', NULL, 1, '2016-04-27 15:19:07', NULL, NULL, NULL, NULL),
(139, '123', 77, '2', '2016-04-27', 2, 2, 4, 12, 12, NULL, '', NULL, 10, 'Good', NULL, 1, '2016-04-27 15:22:19', NULL, NULL, NULL, NULL),
(140, '123', 77, '2', '2016-04-27', 2, 2, 4, 12, 12, NULL, '', NULL, 10, 'Good', NULL, 1, '2016-04-27 15:22:20', NULL, NULL, NULL, NULL),
(141, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:45:04', NULL, NULL, NULL, NULL),
(142, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:45:04', NULL, NULL, NULL, NULL),
(143, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:49:51', NULL, NULL, NULL, NULL),
(144, '123', 77, '2', '2016-04-26', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 15:49:51', NULL, NULL, NULL, NULL),
(145, '123', 77, '2', '2016-04-26', 3, 3, 9, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 16:01:20', NULL, NULL, NULL, NULL),
(146, '123', 77, '2', '2016-04-26', 3, 3, 9, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-27 16:01:20', NULL, NULL, NULL, NULL),
(147, '454', 75, '2', '2016-04-29', 5, 10, 50, 12, 12, NULL, '', NULL, 350, 'gff', NULL, 1, '2016-04-29 21:33:29', NULL, NULL, NULL, NULL),
(148, '454', 75, '2', '2016-04-29', 5, 10, 50, 12, 12, NULL, '', NULL, 350, 'gff', NULL, 1, '2016-04-29 21:33:30', NULL, NULL, NULL, NULL),
(149, '454', 77, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 08:01:14', NULL, NULL, NULL, NULL),
(150, '454', 77, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 08:01:15', NULL, NULL, NULL, NULL),
(151, '454', 77, '2', '2016-04-29', 7, 1, 7, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 08:02:33', NULL, NULL, NULL, NULL),
(152, '454', 77, '2', '2016-04-29', 7, 1, 7, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 08:02:33', NULL, NULL, NULL, NULL),
(155, '454', 77, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:08:05', NULL, NULL, NULL, NULL),
(156, '454', 77, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:08:06', NULL, NULL, NULL, NULL),
(157, '454', 78, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:13:36', NULL, NULL, NULL, NULL),
(158, '454', 78, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:13:37', NULL, NULL, NULL, NULL),
(159, '454', 78, '2', '2016-04-29', 4, 2, 8, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:38:25', NULL, NULL, NULL, NULL),
(160, '454', 78, '2', '2016-04-29', 4, 2, 8, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:38:26', NULL, NULL, NULL, NULL),
(161, '454', 78, '0', '2016-04-29', 3, 2, 6, 12, 11, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:40:05', NULL, NULL, NULL, NULL),
(162, '454', 78, '0', '2016-04-29', 3, 2, 6, 12, 11, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:40:06', NULL, NULL, NULL, NULL),
(163, '454', 78, '5', '2016-04-29', 3, 1, 3, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:44:00', NULL, NULL, NULL, NULL),
(164, '454', 78, '5', '2016-04-29', 3, 1, 3, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:44:00', NULL, NULL, NULL, NULL),
(165, '454', 78, '5', '2016-04-29', 2, 1, 2, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:45:24', NULL, NULL, NULL, NULL),
(166, '454', 78, '5', '2016-04-29', 2, 1, 2, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:45:24', NULL, NULL, NULL, NULL),
(167, '454', 78, '5', '2016-04-29', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:50:26', NULL, NULL, NULL, NULL),
(168, '454', 78, '5', '2016-04-29', 2, 2, 4, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:50:27', NULL, NULL, NULL, NULL),
(169, '454', 78, '5', '2016-04-29', 5, 1, 5, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:51:36', NULL, NULL, NULL, NULL),
(170, '454', 78, '5', '2016-04-29', 5, 1, 5, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 20:51:37', NULL, NULL, NULL, NULL),
(171, '454', 78, '1', '2016-04-30', 2, 1, 2, 11, 11, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 21:05:35', NULL, NULL, NULL, NULL),
(172, '454', 78, '1', '2016-04-30', 2, 1, 2, 11, 11, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 21:05:36', NULL, NULL, NULL, NULL),
(173, '454', 78, '1', '2016-04-29', 0, 0, NULL, 12, 12, NULL, '', NULL, NULL, NULL, NULL, 1, '2016-04-30 21:06:52', NULL, NULL, NULL, NULL),
(174, '454', 78, '1', '2016-04-29', 0, 0, NULL, 12, 12, NULL, '', NULL, NULL, NULL, NULL, 1, '2016-04-30 21:06:53', NULL, NULL, NULL, NULL),
(175, '454', 78, '1', '2016-04-29', 0, 0, NULL, 12, 12, NULL, '', NULL, NULL, NULL, NULL, 1, '2016-04-30 21:08:43', NULL, NULL, NULL, NULL),
(176, '454', 78, '1', '2016-04-29', 0, 0, NULL, 12, 12, NULL, '', NULL, NULL, NULL, NULL, 1, '2016-04-30 21:08:43', NULL, NULL, NULL, NULL),
(177, NULL, 78, NULL, NULL, 0, 0, NULL, 0, 0, NULL, '', NULL, NULL, NULL, NULL, 1, '2016-04-30 21:10:23', NULL, NULL, NULL, NULL),
(178, NULL, 78, NULL, NULL, 0, 0, NULL, 0, 0, NULL, '', NULL, NULL, NULL, NULL, 1, '2016-04-30 21:10:24', NULL, NULL, NULL, NULL),
(179, '454', 78, '2', '2016-04-29', 9, 1, 9, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 21:16:22', NULL, NULL, NULL, NULL),
(180, '454', 78, '2', '2016-04-29', 9, 1, 9, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 21:16:22', NULL, NULL, NULL, NULL),
(181, '454', 78, '2', '2016-04-29', 7, 1, 7, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 21:19:22', NULL, NULL, NULL, NULL),
(182, '454', 78, '2', '2016-04-29', 7, 1, 7, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 21:19:23', NULL, NULL, NULL, NULL),
(183, '454', 78, '2', '2016-04-29', 0, 0, 1, 0, 0, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 22:17:16', NULL, NULL, NULL, NULL),
(184, '454', 78, '2', '2016-04-30', 1, 1, 1, 0, 0, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 22:29:51', NULL, NULL, NULL, NULL),
(185, '454', 78, '2', '2016-04-30', 1, 1, 1, 0, 0, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 22:31:01', NULL, NULL, NULL, NULL),
(186, '454', 78, '2', '2016-04-30', 1, 1, 1, 0, 0, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 22:33:27', NULL, NULL, NULL, NULL),
(187, '454', 78, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 23:13:22', NULL, NULL, NULL, NULL),
(188, '454', 78, '2', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 23:13:22', NULL, NULL, NULL, NULL),
(189, '12', 77, '2', '2016-04-30', 2, 1, 2, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 23:16:35', NULL, NULL, NULL, NULL),
(190, '12', 77, '2', '2016-04-30', 2, 1, 2, 12, 12, NULL, '', NULL, 10, '', NULL, 1, '2016-04-30 23:16:35', NULL, NULL, NULL, NULL),
(191, '454', 79, '1', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 05:55:01', NULL, NULL, NULL, NULL),
(192, '454', 79, '1', '2016-04-29', 1, 1, 1, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 05:55:02', NULL, NULL, NULL, NULL),
(193, '454', 79, '1', '2016-04-30', 0, 0, 1, 0, 0, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 05:57:26', NULL, NULL, NULL, NULL),
(194, '454', 79, '1', '2016-04-29', 0, 0, 2, 12, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 05:59:27', NULL, NULL, NULL, NULL),
(195, '454', 79, '1', '2016-04-29', 0, 0, 2, 12, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 05:59:28', NULL, NULL, NULL, NULL),
(196, '454', 79, '1', '2016-04-29', 0, 0, 3, 12, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:00:11', NULL, NULL, NULL, NULL),
(197, '454', 79, '1', '2016-04-29', 0, 0, 3, 12, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:00:11', NULL, NULL, NULL, NULL),
(198, '12', 79, '1', '2016-04-29', 0, 0, 7, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:01:51', NULL, NULL, NULL, NULL),
(199, '454', 79, '1', '2016-04-29', 0, 0, 3, 12, 11, NULL, '4', NULL, 20, '', NULL, 1, '2016-05-01 06:03:40', NULL, NULL, NULL, NULL),
(200, '454', 79, '1', '2016-04-29', 0, 0, 3, 12, 11, NULL, '4', NULL, 20, '', NULL, 1, '2016-05-01 06:03:40', NULL, NULL, NULL, NULL),
(201, '454', 79, '1', '2016-05-12', 0, 0, 2, 12, 12, NULL, '4', NULL, 20, '', NULL, 1, '2016-05-01 06:07:43', NULL, NULL, NULL, NULL),
(202, '454', 79, '1', '2016-05-12', 0, 0, 2, 12, 12, NULL, '4', NULL, 20, '', NULL, 1, '2016-05-01 06:07:43', NULL, NULL, NULL, NULL),
(203, '454', 79, '1', '2016-04-29', 0, 0, 4, 12, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:09:11', NULL, NULL, NULL, NULL),
(204, '454', 79, '1', '2016-04-29', 0, 0, 4, 12, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:09:12', NULL, NULL, NULL, NULL),
(205, '454', 79, '1', '2016-04-29', 0, 0, 3, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:10:09', NULL, NULL, NULL, NULL),
(206, '454', 79, '1', '2016-04-29', 0, 0, 1, 12, 12, NULL, '2', NULL, 20, '', NULL, 1, '2016-05-01 06:17:26', NULL, NULL, NULL, NULL),
(207, '454', 79, '1', '2016-04-29', 0, 0, 1, 12, 12, NULL, '2', NULL, 20, '', NULL, 1, '2016-05-01 06:17:27', NULL, NULL, NULL, NULL),
(208, '454', 79, '1', '2016-04-29', 0, 0, 3, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:19:02', NULL, NULL, NULL, NULL),
(209, '454', 79, '1', '2016-04-29', 0, 0, 3, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:19:03', NULL, NULL, NULL, NULL),
(210, '454', 79, '1', '2016-04-29', 0, 0, 1, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:20:59', NULL, NULL, NULL, NULL),
(211, '454', 79, '1', '2016-04-29', 0, 0, 1, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:21:00', NULL, NULL, NULL, NULL),
(212, '454', 79, '1', '2016-04-29', 0, 0, 2, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:22:07', NULL, NULL, NULL, NULL),
(213, '454', 79, '1', '2016-04-29', 0, 0, 5, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:23:14', NULL, NULL, NULL, NULL),
(214, '454', 79, '1', '2016-04-29', 0, 0, 2, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:23:49', NULL, NULL, NULL, NULL),
(215, '454', 79, '1', '2016-04-29', 0, 0, 2, 12, 12, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:23:49', NULL, NULL, NULL, NULL),
(216, '454', 79, '1', '2016-04-29', 0, 0, 3, 11, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:24:25', NULL, NULL, NULL, NULL),
(217, '12', 79, '1', '2016-04-29', 0, 0, 4, 11, 11, NULL, '', NULL, 20, '', NULL, 1, '2016-05-01 06:25:35', NULL, NULL, NULL, NULL),
(218, '454', 79, '1', '2016-04-29', 0, 0, 2, 12, 11, NULL, '4', NULL, 20, '', NULL, 1, '2016-05-01 06:26:28', NULL, NULL, NULL, NULL),
(219, '454', 79, '1', '2016-04-29', 2, 2, 4, 12, 12, NULL, '9', NULL, 20, '', NULL, 1, '2016-05-01 06:28:17', NULL, NULL, NULL, NULL),
(220, '454', 79, '1', '2016-04-29', 1, 5, 5, 12, 12, NULL, '9', NULL, 20, '', NULL, 1, '2016-05-01 06:28:47', NULL, NULL, NULL, NULL),
(221, '454', 79, '1', '2016-04-29', 5, 5, 25, 12, 11, NULL, '9', NULL, 20, '', NULL, 1, '2016-05-01 08:16:48', NULL, NULL, NULL, NULL),
(222, '454', 79, '1', '2016-04-29', 5, 50, 250, 12, 12, NULL, '9', NULL, 20, '', NULL, 1, '2016-05-09 11:47:48', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requisition`
--

CREATE TABLE IF NOT EXISTS `purchase_requisition` (
  `id` int(11) NOT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `max_sl_no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `approve_to` int(11) NOT NULL,
  `req_by` int(11) NOT NULL,
  `qty` double DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `is_pp_created` int(11) DEFAULT '0',
  `is_po_created` int(11) DEFAULT '0',
  `store_req_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_requisition`
--

INSERT INTO `purchase_requisition` (`id`, `sl_no`, `max_sl_no`, `date`, `store`, `item`, `department`, `approve_to`, `req_by`, `qty`, `cost`, `remarks`, `created_by`, `created_time`, `updated_by`, `updated_time`, `is_pp_created`, `is_po_created`, `store_req_id`) VALUES
(1, '201601211', 1, '2016-01-21', 1, 1, 1, 0, 0, 100000, 550, '', 1, '2016-01-21 04:56:29', NULL, NULL, 1, 0, NULL),
(2, '201601211', 1, '2016-01-21', 1, 2, 1, 0, 0, 100000, 550, '', 1, '2016-01-21 04:56:29', NULL, NULL, 1, 0, NULL),
(3, '201601211', 1, '2016-01-21', 1, 3, 1, 0, 0, 100000, 550, '', 1, '2016-01-21 04:56:29', NULL, NULL, 1, 0, NULL),
(4, '201601251', 1, '2016-01-25', 1, 2, 1, 0, 0, 6, 50, '', 1, '2016-01-25 20:51:01', NULL, NULL, 1, 0, NULL),
(5, '201601011', 1, '2016-01-01', NULL, NULL, 1, 0, 0, 50, 100, '', 1, '2016-01-29 13:39:18', NULL, NULL, 0, 0, NULL),
(6, '201603101', 1, '2016-03-10', 1, 10, 1, 0, 0, 50, 1500, 'for production', 1, '2016-03-10 00:41:06', NULL, NULL, 0, 0, NULL),
(7, '201603141', 1, '2016-03-14', 1, 14, 1, 0, 0, 5, 100, 'Urgent', 1, '2016-03-14 08:38:36', NULL, NULL, 1, 0, NULL),
(8, '201603151', 1, '2016-03-15', 1, 9, 1, 0, 0, 10, 100, '', 1, '2016-03-15 00:20:48', NULL, NULL, 0, 0, NULL),
(9, '201603181', 1, '2016-03-18', 1, 3, 1, 0, 0, 1, 100, '', 1, '2016-03-18 09:08:03', NULL, NULL, 0, 0, NULL),
(10, '201603182', 2, '2016-03-18', 1, 27, 1, 0, 0, 101, 100, '', 1, '2016-03-18 09:09:36', NULL, NULL, 1, 0, NULL),
(11, '201603183', 3, '2016-03-18', 1, 9, 1, 0, 0, 100, 10, '', 1, '2016-03-18 09:19:21', NULL, NULL, 0, 0, NULL),
(12, '201603184', 4, '2016-03-18', 1, 27, 1, 0, 0, 1, 100, '', 1, '2016-03-18 14:45:02', NULL, NULL, 1, 0, NULL),
(13, '201603185', 5, '2016-03-18', 1, 3, 1, 1, 2, 1, 100, '', 1, '2016-03-18 14:55:47', NULL, NULL, 0, 0, NULL),
(14, '201603186', 6, '2016-03-18', 2, 9, 1, 1, 2, 1, 100, '', 1, '2016-03-18 17:00:32', NULL, NULL, 1, 0, NULL),
(15, '201603187', 7, '2016-03-18', 2, 17, 1, 1, 2, 1, 1000, '', 1, '2016-03-18 17:01:44', NULL, NULL, 0, 0, NULL),
(16, '201603188', 8, '2016-03-18', 1, 1, 1, 1, 2, 1, 100, '', 1, '2016-03-18 19:26:13', NULL, NULL, 1, 0, NULL),
(18, '2016031810', 10, '2016-03-18', 2, 3, 1, 1, 2, 1, 100, '', 1, '2016-03-18 19:32:37', NULL, NULL, 0, 0, NULL),
(19, '2016031811', 11, '2016-03-18', 1, 3, 1, 1, 2, 1, 100, '', 1, '2016-03-18 19:34:25', NULL, NULL, 0, 0, NULL),
(20, '2016031812', 12, '2016-03-18', 2, 6, 1, 1, 2, 1, 1000, '', 1, '2016-03-18 19:37:17', NULL, NULL, 0, 0, NULL),
(21, '2016031813', 13, '2016-03-18', 1, 3, 1, 1, 2, 1, 100, '', 1, '2016-03-18 19:39:48', NULL, NULL, 0, 0, NULL),
(22, '2016031814', 14, '2016-03-18', 2, 9, 1, 2, 3, 1, 1000, '', 1, '2016-03-18 19:45:32', NULL, NULL, 0, 0, NULL),
(23, '2016031815', 15, '2016-03-18', 1, 3, 1, 3, 2, 1, 1000, '', 1, '2016-03-18 19:49:43', NULL, NULL, 0, 0, NULL),
(24, '2016031816', 16, '2016-03-18', 1, 9, 1, 1, 3, 1, 1000, '', 1, '2016-03-18 19:52:00', NULL, NULL, 0, 0, NULL),
(25, '2016031817', 17, '2016-03-18', 1, 6, 1, 2, 3, 1, 1000, '', 1, '2016-03-18 19:53:34', NULL, NULL, 0, 0, NULL),
(26, '2016031818', 18, '2016-03-18', 2, 5, 2, 2, 3, 1, 1000, '', 1, '2016-03-18 19:59:50', NULL, NULL, 0, 0, NULL),
(27, '2016031819', 19, '2016-03-18', 2, 18, 2, 2, 3, 1, 1000, '', 1, '2016-03-18 20:17:16', NULL, NULL, 0, 0, NULL),
(28, '201603201', 1, '2016-03-20', 1, 12, 2, 1, 4, 15, 100, 'Urgent', 1, '2016-03-20 21:50:19', NULL, NULL, 0, 0, NULL),
(29, '201603201', 1, '2016-03-20', 1, 13, 2, 1, 4, 20, 100, 'Urgent', 1, '2016-03-20 21:50:19', NULL, NULL, 0, 0, NULL),
(30, '201603202', 2, '2016-03-20', 1, 12, 2, 1, 4, 15, 100, 'Urgent', 1, '2016-03-20 21:50:20', NULL, NULL, 1, 0, NULL),
(31, '201603202', 2, '2016-03-20', 1, 13, 2, 1, 4, 20, 100, 'Urgent', 1, '2016-03-20 21:50:20', NULL, NULL, 1, 0, NULL),
(32, '201603203', 3, '2016-03-20', 1, 12, 2, 1, 4, 15, 100, 'Urgent', 1, '2016-03-20 21:50:21', NULL, NULL, 0, 0, NULL),
(33, '201603203', 3, '2016-03-20', 1, 13, 2, 1, 4, 20, 100, 'Urgent', 1, '2016-03-20 21:50:21', NULL, NULL, 0, 0, NULL),
(34, '201603204', 4, '2016-03-20', 1, 12, 2, 1, 4, 15, 100, 'Urgent', 1, '2016-03-20 21:50:22', NULL, NULL, 1, 0, NULL),
(35, '201603204', 4, '2016-03-20', 1, 13, 2, 1, 4, 20, 100, 'Urgent', 1, '2016-03-20 21:50:22', NULL, NULL, 1, 0, NULL),
(36, '201603205', 5, '2016-03-20', 1, 12, 2, 1, 4, 15, 100, 'Urgent', 1, '2016-03-20 21:50:23', NULL, NULL, 1, 0, NULL),
(37, '201603205', 5, '2016-03-20', 1, 13, 2, 1, 4, 20, 100, 'Urgent', 1, '2016-03-20 21:50:23', NULL, NULL, 1, 0, NULL),
(38, '201603206', 6, '2016-03-20', 1, 12, 2, 1, 4, 15, 100, 'Urgent', 1, '2016-03-20 21:50:24', NULL, NULL, 1, 0, NULL),
(39, '201603206', 6, '2016-03-20', 1, 13, 2, 1, 4, 20, 100, 'Urgent', 1, '2016-03-20 21:50:24', NULL, NULL, 1, 0, NULL),
(40, '201603221', 1, '2016-03-22', 1, 7, 1, 3, 3, 10, 20, 'Test', 1, '2016-03-22 18:18:36', 1, '2016-03-24 07:13:59', 1, 0, NULL),
(41, '201603221', 1, '2016-03-22', 1, 5, 1, 3, 3, 100, 100, 'Test', 1, '2016-03-22 18:18:36', 1, '2016-03-24 07:13:59', 1, 0, NULL),
(42, '201604251', 1, '2016-04-25', 8, 28, 3, 12, 11, 50, 350, '', 1, '2016-04-25 15:57:22', NULL, NULL, 1, 0, NULL),
(43, '201604261', 1, '2016-04-26', 4, 29, 1, 12, 11, 1000, 10, 'Argent', 1, '2016-04-26 14:45:50', NULL, NULL, 1, 0, NULL),
(44, '201604262', 2, '2016-04-26', 8, 29, 1, 12, 12, 100, 10, '', 1, '2016-04-26 17:06:05', NULL, NULL, 1, 0, NULL),
(45, '201604271', 1, '2016-04-27', 3, 28, 1, 12, 11, 100, 10, '', 1, '2016-04-27 14:11:58', NULL, NULL, 1, 0, NULL),
(46, '201604272', 2, '2016-04-27', 3, 28, 1, 12, 12, 10, 10, '', 1, '2016-04-27 15:50:55', NULL, NULL, 0, 0, NULL),
(47, '201604301', 1, '2016-04-30', 3, 33, 1, 12, 12, 100, 10, '', 1, '2016-04-30 20:12:02', NULL, NULL, 1, 0, NULL),
(48, '201604302', 2, '2016-04-30', 3, 33, 1, 12, 12, 10000, 20, '', 1, '2016-04-30 23:17:34', NULL, NULL, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `p_brand`
--

CREATE TABLE IF NOT EXISTS `p_brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `p_brand`
--

INSERT INTO `p_brand` (`id`, `name`) VALUES
(1, 'Brand One');

-- --------------------------------------------------------

--
-- Table structure for table `p_model`
--

CREATE TABLE IF NOT EXISTS `p_model` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `p_model`
--

INSERT INTO `p_model` (`id`, `name`) VALUES
(1, 'Model One');

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_order`
--

CREATE TABLE IF NOT EXISTS `sale_order` (
  `id` int(11) NOT NULL,
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
  `is_stopped` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale_order`
--

INSERT INTO `sale_order` (`id`, `sl_no`, `max_sl_no`, `issue_date`, `expected_d_date`, `subj`, `order_type2`, `pi_no`, `pi_date`, `store`, `customer_id`, `contact_person`, `item`, `qty`, `price`, `conv_unit`, `sales_by`, `created_by`, `created_time`, `updated_by`, `updated_time`, `is_stopped`) VALUES
(10, '201601231', 1, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 2, 2, 500, NULL, 1, 1, '2016-01-23 21:32:48', NULL, NULL, 1),
(11, '201601231', 1, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 1, 2, 500, NULL, 1, 1, '2016-01-23 21:32:48', NULL, NULL, 1),
(12, '201601232', 2, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 2, 10, 100, NULL, 1, 1, '2016-01-23 21:40:12', NULL, NULL, 1),
(13, '201601233', 3, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 1, 15, 200, NULL, 1, 1, '2016-01-23 21:41:32', NULL, NULL, 1),
(14, '201601234', 4, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 4, 10, 250, 3, 1, 1, '2016-01-23 23:22:55', NULL, NULL, 1),
(15, '201601235', 5, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 3, 10, 100, 3, 1, 1, '2016-01-23 23:38:17', NULL, NULL, 1),
(16, '201601236', 6, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 2, 1, 150, NULL, 1, 1, '2016-01-23 23:42:24', NULL, NULL, 1),
(17, '201601237', 7, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 1, 3, 160, NULL, 1, 1, '2016-01-23 23:53:14', NULL, NULL, 0),
(18, '201601237', 7, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 3, 3, 100, 3, 1, 1, '2016-01-23 23:53:14', NULL, NULL, 0),
(19, '201601237', 7, '2016-01-23', '2016-01-23', '', 18, '', '0000-00-00', 1, 1, 1, 2, 3, 150, NULL, 1, 1, '2016-01-23 23:53:14', NULL, NULL, 0),
(20, '201601241', 1, '2016-01-24', '2016-01-24', '', 18, '', '0000-00-00', 1, 1, 1, 4, 10, 250, 3, 1, 1, '2016-01-24 00:06:24', NULL, NULL, 0),
(21, '201601242', 2, '2016-01-24', '2016-01-24', '', 18, '', '0000-00-00', 1, 1, 1, 2, 6, 150, NULL, 1, 1, '2016-01-24 01:02:57', NULL, NULL, 0),
(22, '201601243', 3, '2016-01-24', '2016-01-24', '', 18, '', '0000-00-00', 1, 1, 1, 4, 10, 250, 1, 1, 1, '2016-01-24 01:11:38', NULL, NULL, 0),
(23, '201601244', 4, '2016-01-24', '2016-01-24', '', 18, '', '0000-00-00', 1, 1, 1, 3, 10, 100, 3, 1, 1, '2016-01-24 11:19:46', NULL, NULL, 0),
(24, '201601244', 4, '2016-01-24', '2016-01-24', '', 18, '', '0000-00-00', 1, 1, 1, 4, 10, 250, 1, 1, 1, '2016-01-24 11:19:46', NULL, NULL, 1),
(25, '201601251', 1, '2016-01-25', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, 1, 9, 1, 35, NULL, 1, 1, '2016-01-25 21:01:07', NULL, NULL, 0),
(26, '201601252', 2, '2016-01-25', '2016-01-25', '', 18, '', '0000-00-00', 1, 1, 1, 4, 2, 250, NULL, 1, 1, '2016-01-25 21:46:53', NULL, NULL, 0),
(27, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 4, 300, 250, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(28, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 7, 300, 100, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(29, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 5, 300, 100, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(30, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 6, 300, 100, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(31, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 9, 300, 100, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(32, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 2, 300, 150, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(33, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 1, 300, 160, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(34, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 3, 300, 100, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0),
(35, '201601261', 1, '2016-01-26', '2016-01-26', '', 18, '', '0000-00-00', 1, 1, NULL, 8, 300, 200, NULL, 1, 1, '2016-01-26 01:19:43', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `selling_price`
--

CREATE TABLE IF NOT EXISTS `selling_price` (
  `id` int(11) NOT NULL,
  `item` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sell_delv_rtn`
--

CREATE TABLE IF NOT EXISTS `sell_delv_rtn` (
  `id` int(11) NOT NULL,
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
  `return_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sell_delv_rtn`
--

INSERT INTO `sell_delv_rtn` (`id`, `bill`, `sl_no`, `max_sl_no`, `so_id`, `customer_id`, `vehicle_type`, `vehicle_no`, `item`, `store`, `so_no`, `d_date`, `d_qty`, `r_date`, `r_qty`, `remarks1`, `remarks`, `d_qty_kg`, `r_qty_kg`, `created_by`, `created_time`, `updated_by`, `updated_time`, `return_by`, `return_time`) VALUES
(38, 1, '201601241', 1, 22, 1, '', '', 4, 1, '201601243', '2016-01-24', 10, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 01:17:44', NULL, NULL, NULL, NULL),
(39, 1, '201601242', 2, 21, 1, '', '', 2, 1, '201601242', '2016-01-24', 6, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 01:17:56', NULL, NULL, NULL, NULL),
(40, 1, '201601243', 3, 20, 1, '', '', 4, 1, '201601241', '2016-01-24', 10, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 01:18:08', NULL, NULL, NULL, NULL),
(41, 1, '201601244', 4, 17, 1, '', '', 1, 1, '201601237', '2016-01-24', 3, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 01:18:25', NULL, NULL, NULL, NULL),
(42, 1, '201601244', 4, 18, 1, '', '', 3, 1, '201601237', '2016-01-24', 3, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 01:18:25', NULL, NULL, NULL, NULL),
(43, 1, '201601244', 4, 19, 1, '', '', 2, 1, '201601237', '2016-01-24', 3, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 01:18:25', NULL, NULL, NULL, NULL),
(44, 1, '201601245', 5, 23, 1, '', '', 3, 1, '201601244', '2016-01-24', 5, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 11:20:28', NULL, NULL, NULL, NULL),
(45, 1, '201601246', 6, 23, 1, '', '', 3, 1, '201601244', '2016-01-24', 5, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 11:20:39', NULL, NULL, NULL, NULL),
(46, 1, '201601247', 7, 24, 1, '', '', 4, 1, '201601244', '2016-01-24', 5, NULL, NULL, '', NULL, NULL, NULL, 1, '2016-01-24 11:20:52', NULL, NULL, NULL, NULL),
(47, 0, '201604131', 1, 27, 1, 'bus', '10', 4, 1, '201601261', '2016-04-13', 10, NULL, NULL, '67', NULL, NULL, NULL, 1, '2016-04-15 06:15:11', NULL, NULL, NULL, NULL),
(48, 0, '201604151', 1, 27, 1, 'bus', '10', 4, 1, '201601261', '2016-04-15', 1, NULL, NULL, '67', NULL, 100, NULL, 1, '2016-04-15 09:59:37', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `signature`
--

CREATE TABLE IF NOT EXISTS `signature` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `signature` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_history`
--

CREATE TABLE IF NOT EXISTS `stock_transfer_history` (
  `id` int(11) NOT NULL,
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
  `rcv_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storck_tranfer_history_from_temp_to_main`
--

CREATE TABLE IF NOT EXISTS `storck_tranfer_history_from_temp_to_main` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `from_temp_store` int(11) DEFAULT NULL,
  `to_main_store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(11) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `store_name`, `location`) VALUES
(3, 'RawMaterialStore', 'Gazipur'),
(4, 'FinishGoodsStore', 'Gazipur'),
(5, 'GarbageStore', 'Gazipur'),
(6, 'ProductionStore', 'Gazipur'),
(7, 'SalesStore', 'Gazipur'),
(8, 'PurchaseStore', 'Gazipur'),
(9, 'Configure', 'Gazipur');

-- --------------------------------------------------------

--
-- Table structure for table `store_inventory`
--

CREATE TABLE IF NOT EXISTS `store_inventory` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `stock_in` double DEFAULT NULL,
  `stock_out` double DEFAULT NULL,
  `costing_price` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_inventory`
--

INSERT INTO `store_inventory` (`id`, `date`, `store`, `item`, `stock_in`, `stock_out`, `costing_price`) VALUES
(1, '2016-01-24', 1, 4, 1, NULL, 0),
(2, '2016-01-24', 1, 4, NULL, 1, NULL),
(3, '2016-04-16', 1, 24, 12, NULL, 0),
(4, '2016-05-20', 9, 36, 1, NULL, 0),
(5, '2016-05-09', 6, 36, NULL, 1, NULL),
(6, '2016-05-13', 3, 34, 100, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `store_requisition`
--

CREATE TABLE IF NOT EXISTS `store_requisition` (
  `id` int(11) NOT NULL,
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
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_requisition`
--

INSERT INTO `store_requisition` (`id`, `sl_no`, `max_sl_no`, `remarks`, `department`, `from_store`, `store`, `item`, `qty`, `req_date`, `req_by`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, '201603181', 1, 'good', 1, 1, 2, 27, 1, '2016-03-18', 1, 1, '2016-03-18 16:14:25', NULL, NULL),
(2, '201603241', 1, 'Urgent', 1, 1, 2, 17, 100, '2016-03-24', 1, 1, '2016-03-24 07:08:48', NULL, NULL),
(3, '201603242', 2, 'goods', 2, 1, 2, 6, 150, '2016-03-24', 1, 1, '2016-03-24 07:11:31', NULL, NULL),
(4, '201604131', 1, 'hjhg', 1, 1, 2, 27, 2, '2016-04-13', 1, 1, '2016-04-13 08:03:51', NULL, NULL),
(5, '201604161', 1, 'jkkk', 1, 1, 2, 17, 1, '2016-04-16', 1, 1, '2016-04-16 06:14:42', NULL, NULL),
(6, '201604171', 1, 'h', 1, 2, 1, 5, 1, '2016-04-17', 1, 1, '2016-04-17 14:48:57', NULL, NULL),
(7, '201604181', 1, '.m', 1, 1, 2, 9, 1, '2016-04-18', 1, 1, '2016-04-18 08:24:55', NULL, NULL),
(8, '201604251', 1, 'ghhgh', 1, 6, 3, 28, 1, '2016-04-25', 12, 1, '2016-04-25 16:20:46', NULL, NULL),
(9, '201604252', 2, 'gfdfd', 5, 6, 3, 28, 50, '2016-04-25', 12, 1, '2016-04-25 16:25:45', NULL, NULL),
(10, '201605091', 1, 'o', 1, 6, 3, 33, 10, '2016-05-09', 12, 1, '2016-05-09 12:12:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_req_d_r`
--

CREATE TABLE IF NOT EXISTS `store_req_d_r` (
  `id` int(11) NOT NULL,
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
  `approved_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_req_d_r`
--

INSERT INTO `store_req_d_r` (`id`, `req_no`, `req_id`, `d_qty`, `d_date`, `r_qty`, `r_date`, `remarks`, `created_by`, `created_time`, `updated_by`, `updated_time`, `return_by`, `return_time`, `is_approved`, `approved_by`, `approved_time`) VALUES
(1, '201604252', 9, 50, '2016-04-25', NULL, NULL, NULL, 1, '2016-04-25 16:27:03', NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text,
  `company_contact_no` varchar(20) DEFAULT NULL,
  `company_fax` varchar(20) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_web` varchar(50) DEFAULT NULL,
  `opening_amount` double DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `id_no`, `company_name`, `company_address`, `company_contact_no`, `company_fax`, `company_email`, `company_web`, `opening_amount`) VALUES
(1, '20160120110154', 'Supplier One', '', '', '', '', '', 0),
(2, '20160125030102', 'Feku', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_contact_persons`
--

CREATE TABLE IF NOT EXISTS `supplier_contact_persons` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `contact_number1` varchar(20) DEFAULT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `contact_number3` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_mr`
--

CREATE TABLE IF NOT EXISTS `supplier_mr` (
  `id` int(11) NOT NULL,
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
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_mr`
--

INSERT INTO `supplier_mr` (`id`, `max_sl_no`, `sl_no`, `supplier_id`, `date`, `narration`, `received_type`, `bank_id`, `cheque_no`, `cheque_date`, `paid_amount`, `discount`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(5, 1, '201601231', 1, '2016-01-23', 'sg', 20, NULL, 'dd', '0000-00-00', 100000000, 0, 1, '2016-01-23 22:31:03', 1, '2016-04-15 00:27:15'),
(6, 1, '201603211', 1, '2016-03-21', '', 20, NULL, '', '2016-03-14', 1000, 0, 1, '2016-03-21 23:54:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenors`
--

CREATE TABLE IF NOT EXISTS `tenors` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tenors`
--

INSERT INTO `tenors` (`id`, `title`) VALUES
(1, '30'),
(2, '60'),
(3, '120');

-- --------------------------------------------------------

--
-- Table structure for table `unitdistance`
--

CREATE TABLE IF NOT EXISTS `unitdistance` (
  `id` int(11) NOT NULL,
  `unit_of_distance` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unitdistance`
--

INSERT INTO `unitdistance` (`id`, `unit_of_distance`) VALUES
(1, 'Meter'),
(2, 'Inch'),
(4, 'ft'),
(5, 'hhg'),
(6, 'lklkl');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`) VALUES
(1, 'Kg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL,
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
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `username`, `password`, `real_password`, `is_pos_user`, `is_authorizer`, `pin_code`, `real_pin_code`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 1, 'superadmin', '17c4520f6cfd1ab53d8745e84681eb49', 'superadmin', 0, 1, '81dc9bdb52d04dc20036dbd8313ed055', '1234', NULL, NULL, 'superadmin', '2016-01-27 19:41:00'),
(2, 2, 'tanim123', '12f3315cf1ba3c9164ecceea3bbf3a86', 'tanim123', 1, 0, 'd41d8cd98f00b204e9800998ecf8427e', '', 'superadmin', '2016-01-27 19:40:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_store`
--

CREATE TABLE IF NOT EXISTS `user_store` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_store`
--

INSERT INTO `user_store` (`id`, `user_id`, `store_id`, `is_active`) VALUES
(1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `your_company`
--

CREATE TABLE IF NOT EXISTS `your_company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `vat_regi_no` varchar(255) DEFAULT NULL,
  `vat_amount` double DEFAULT NULL,
  `is_active` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authassignment`
--
ALTER TABLE `authassignment`
  ADD PRIMARY KEY (`itemname`,`userid`);

--
-- Indexes for table `authitem`
--
ALTER TABLE `authitem`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cats_sub`
--
ALTER TABLE `cats_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `costing_price`
--
ALTER TABLE `costing_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_costing_price` (`item`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_memo`
--
ALTER TABLE `credit_memo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_bill`
--
ALTER TABLE `customer_bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_contact_persons`
--
ALTER TABLE `customer_contact_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_contact_persons2` (`company_id`),
  ADD KEY `FK_contact_persons_designation` (`designation_id`);

--
-- Indexes for table `customer_mr`
--
ALTER TABLE `customer_mr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_document`
--
ALTER TABLE `import_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_import_document` (`lc_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lookup`
--
ALTER TABLE `lookup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_names`
--
ALTER TABLE `machine_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_lc`
--
ALTER TABLE `master_lc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_points`
--
ALTER TABLE `member_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_member_points` (`member_id`);

--
-- Indexes for table `member_points_conf`
--
ALTER TABLE `member_points_conf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mfis`
--
ALTER TABLE `mfis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos`
--
ALTER TABLE `pos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_input`
--
ALTER TABLE `production_input`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_output`
--
ALTER TABLE `production_output`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_production_output` (`production_input_no`);

--
-- Indexes for table `production_wastage`
--
ALTER TABLE `production_wastage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_purchase_order` (`procurement_id`);

--
-- Indexes for table `purchase_procurement`
--
ALTER TABLE `purchase_procurement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_purchase_procurement` (`req_no`),
  ADD KEY `FK_purchase_procurement1` (`req_id`);

--
-- Indexes for table `purchase_rcv_rtn`
--
ALTER TABLE `purchase_rcv_rtn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_purchase_rcv_rtn` (`po_id`);

--
-- Indexes for table `purchase_requisition`
--
ALTER TABLE `purchase_requisition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_brand`
--
ALTER TABLE `p_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_model`
--
ALTER TABLE `p_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`itemname`);

--
-- Indexes for table `sale_order`
--
ALTER TABLE `sale_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selling_price`
--
ALTER TABLE `selling_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_selling_price` (`item`);

--
-- Indexes for table `sell_delv_rtn`
--
ALTER TABLE `sell_delv_rtn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sell_delv_rtn` (`so_id`);

--
-- Indexes for table `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer_history`
--
ALTER TABLE `stock_transfer_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storck_tranfer_history_from_temp_to_main`
--
ALTER TABLE `storck_tranfer_history_from_temp_to_main`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_inventory`
--
ALTER TABLE `store_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_requisition`
--
ALTER TABLE `store_requisition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_req_d_r`
--
ALTER TABLE `store_req_d_r`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_store_req_d_r` (`req_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_contact_persons`
--
ALTER TABLE `supplier_contact_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_supplier_contact_persons` (`company_id`);

--
-- Indexes for table `supplier_mr`
--
ALTER TABLE `supplier_mr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenors`
--
ALTER TABLE `tenors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unitdistance`
--
ALTER TABLE `unitdistance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_store`
--
ALTER TABLE `user_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_store` (`user_id`);

--
-- Indexes for table `your_company`
--
ALTER TABLE `your_company`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cats_sub`
--
ALTER TABLE `cats_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `costing_price`
--
ALTER TABLE `costing_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=242;
--
-- AUTO_INCREMENT for table `credit_memo`
--
ALTER TABLE `credit_memo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_bill`
--
ALTER TABLE `customer_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `customer_contact_persons`
--
ALTER TABLE `customer_contact_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_mr`
--
ALTER TABLE `customer_mr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `import_document`
--
ALTER TABLE `import_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=313;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `lookup`
--
ALTER TABLE `lookup`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `machine_names`
--
ALTER TABLE `machine_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master_lc`
--
ALTER TABLE `master_lc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `member_points`
--
ALTER TABLE `member_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `member_points_conf`
--
ALTER TABLE `member_points_conf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mfis`
--
ALTER TABLE `mfis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos`
--
ALTER TABLE `pos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `production_input`
--
ALTER TABLE `production_input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `production_output`
--
ALTER TABLE `production_output`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `production_wastage`
--
ALTER TABLE `production_wastage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `purchase_procurement`
--
ALTER TABLE `purchase_procurement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `purchase_rcv_rtn`
--
ALTER TABLE `purchase_rcv_rtn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=223;
--
-- AUTO_INCREMENT for table `purchase_requisition`
--
ALTER TABLE `purchase_requisition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `p_brand`
--
ALTER TABLE `p_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `p_model`
--
ALTER TABLE `p_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sale_order`
--
ALTER TABLE `sale_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `selling_price`
--
ALTER TABLE `selling_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sell_delv_rtn`
--
ALTER TABLE `sell_delv_rtn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `signature`
--
ALTER TABLE `signature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_transfer_history`
--
ALTER TABLE `stock_transfer_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `storck_tranfer_history_from_temp_to_main`
--
ALTER TABLE `storck_tranfer_history_from_temp_to_main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `store_inventory`
--
ALTER TABLE `store_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `store_requisition`
--
ALTER TABLE `store_requisition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `store_req_d_r`
--
ALTER TABLE `store_req_d_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supplier_contact_persons`
--
ALTER TABLE `supplier_contact_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier_mr`
--
ALTER TABLE `supplier_mr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tenors`
--
ALTER TABLE `tenors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `unitdistance`
--
ALTER TABLE `unitdistance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_store`
--
ALTER TABLE `user_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `your_company`
--
ALTER TABLE `your_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `authassignment`
--
ALTER TABLE `authassignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `costing_price`
--
ALTER TABLE `costing_price`
  ADD CONSTRAINT `FK_costing_price` FOREIGN KEY (`item`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_contact_persons`
--
ALTER TABLE `customer_contact_persons`
  ADD CONSTRAINT `FK_contact_persons` FOREIGN KEY (`company_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `import_document`
--
ALTER TABLE `import_document`
  ADD CONSTRAINT `FK_import_document` FOREIGN KEY (`lc_id`) REFERENCES `master_lc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_points`
--
ALTER TABLE `member_points`
  ADD CONSTRAINT `FK_member_points` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `FK_purchase_order` FOREIGN KEY (`procurement_id`) REFERENCES `purchase_procurement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_procurement`
--
ALTER TABLE `purchase_procurement`
  ADD CONSTRAINT `FK_purchase_procurement1` FOREIGN KEY (`req_id`) REFERENCES `purchase_requisition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_rcv_rtn`
--
ALTER TABLE `purchase_rcv_rtn`
  ADD CONSTRAINT `FK_purchase_rcv_rtn` FOREIGN KEY (`po_id`) REFERENCES `purchase_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rights`
--
ALTER TABLE `rights`
  ADD CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `selling_price`
--
ALTER TABLE `selling_price`
  ADD CONSTRAINT `FK_selling_price` FOREIGN KEY (`item`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sell_delv_rtn`
--
ALTER TABLE `sell_delv_rtn`
  ADD CONSTRAINT `FK_sell_delv_rtn` FOREIGN KEY (`so_id`) REFERENCES `sale_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `store_req_d_r`
--
ALTER TABLE `store_req_d_r`
  ADD CONSTRAINT `FK_store_req_d_r` FOREIGN KEY (`req_id`) REFERENCES `store_requisition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier_contact_persons`
--
ALTER TABLE `supplier_contact_persons`
  ADD CONSTRAINT `FK_supplier_contact_persons` FOREIGN KEY (`company_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_store`
--
ALTER TABLE `user_store`
  ADD CONSTRAINT `FK_user_store` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
