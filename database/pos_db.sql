-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2022 at 06:33 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` int(22) NOT NULL,
  `name` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `name`, `title`) VALUES
(1, 'asset', 'Asset'),
(2, 'equity', 'Equity'),
(3, 'liability', 'Liability'),
(4, 'expense', 'Expense'),
(5, 'revenue', 'Revenue'),
(6, 'cos', 'Cost of Sales');

-- --------------------------------------------------------

--
-- Table structure for table `acc_entries`
--

CREATE TABLE `acc_entries` (
  `id` int(11) NOT NULL,
  `company_id` int(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `entry_no` int(50) DEFAULT NULL,
  `dr_total` decimal(10,4) DEFAULT '0.0000',
  `cr_total` decimal(10,4) DEFAULT '0.0000',
  `tag_id` int(11) DEFAULT NULL,
  `entry_type` int(5) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `narration` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acc_entry_items`
--

CREATE TABLE `acc_entry_items` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `account_code` varchar(100) NOT NULL,
  `dueTo_acc_code` varchar(100) NOT NULL,
  `ref_account_id` int(20) DEFAULT '0' COMMENT 'it will be customer, supp or bank id',
  `entry_id` int(11) DEFAULT NULL,
  `entry_no` varchar(50) DEFAULT NULL,
  `reconciliation_date` datetime DEFAULT NULL,
  `debit` double(18,4) NOT NULL,
  `credit` double(18,4) NOT NULL,
  `employee_id` int(100) NOT NULL,
  `date` date NOT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `narration_ur` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(20) NOT NULL,
  `is_cust` tinyint(1) DEFAULT '0',
  `is_supp` tinyint(1) DEFAULT '0',
  `is_bank` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acc_fiscal_years`
--

CREATE TABLE `acc_fiscal_years` (
  `id` int(100) NOT NULL,
  `fy_start_date` date NOT NULL,
  `fy_end_date` date NOT NULL,
  `fy_year` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_fiscal_years`
--

INSERT INTO `acc_fiscal_years` (`id`, `fy_start_date`, `fy_end_date`, `fy_year`, `status`, `company_id`) VALUES
(13, '2020-01-01', '2026-12-31', '2021', 'active', 21),
(14, '2019-09-01', '2019-12-31', '2019', 'active', 22),
(15, '2019-10-01', '2019-10-31', '23234', 'active', 26),
(16, '2020-10-01', '2021-06-30', '2020-21', 'active', 22);

-- --------------------------------------------------------

--
-- Table structure for table `acc_groups`
--

CREATE TABLE `acc_groups` (
  `id` int(11) NOT NULL,
  `parent_code` int(11) NOT NULL,
  `account_type_id` int(25) NOT NULL,
  `account_code` varchar(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_ur` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title_ar` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `op_balance_dr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `op_balance_cr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(20) NOT NULL,
  `level` decimal(20,0) NOT NULL,
  `company_id` int(255) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_groups`
--

INSERT INTO `acc_groups` (`id`, `parent_code`, `account_type_id`, `account_code`, `title`, `title_ur`, `title_ar`, `name`, `op_balance_dr`, `op_balance_cr`, `type`, `level`, `company_id`, `date_created`) VALUES
(233, 0, 1, '1', 'Assets', 'اثاثہ جات', 'الأصول', 'assets', '0.00', '0.00', 'group', '1', 21, '2017-10-20 15:10:42'),
(234, 0, 3, '2', 'Liabilities', 'واجبات', 'المطلوبات', 'Liabilities', '0.00', '0.00', 'group', '1', 21, '2017-10-20 15:10:42'),
(235, 0, 2, '3', 'Equity', 'ایکوٹی', 'القيمة المالية', 'equity', '0.00', '0.00', 'group', '1', 21, '2017-10-20 15:10:42'),
(236, 0, 5, '4', 'Revenue', 'آمدنی', 'إيرادات', 'revenue', '0.00', '0.00', 'group', '1', 21, '2017-10-20 15:10:42'),
(237, 0, 6, '5', 'Cost of Goods Sold', 'فروخت سامان کی قیمت', 'تكلفة البضاعة المباعة', 'cos', '0.00', '0.00', 'group', '1', 21, '2017-10-20 15:10:42'),
(238, 0, 4, '6', 'Expenses', 'اخراجات', 'نفقات', 'expenses', '0.00', '0.00', 'group', '1', 21, '2017-10-20 15:10:42'),
(239, 1, 1, '10', 'Current Assets', 'موجودہ اثاثہ جات', 'الاصول المتداولة', 'current_assets', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(240, 1, 1, '12', 'Fixed Assets', 'مقرر اثاثے', 'أصول ثابتة', 'fixed_assets', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(241, 1, 1, '13', 'Other Assets', 'دیگر اثاثے', 'الأصول الأخرى', 'other_assets', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(242, 2, 3, '20', 'Current Liabilities', 'موجودہ قرضوں', 'المطلوبات المتداولة', 'current_liabilities', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(243, 2, 3, '21', 'Long Term Liabilities', 'طویل مدتی واجبات', 'مطلوبات طويلة الأجل', 'long_term_liabilities', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(244, 3, 2, '30', 'Equity Account', 'ایکوئٹی اکاؤنٹ', 'حساب الأسهم', 'equity_account', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(245, 4, 5, '40', 'Revenue Account', 'ریونیو اکاؤنٹ', 'حساب الإيرادات', 'revenue_account', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(246, 5, 6, '50', 'Cost of goods sold', 'فروخت سامان کی قیمت', '', 'cogs', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(247, 6, 4, '60', 'Operative Expenses', 'آپریٹو اخراجات', 'المصروفات التشغيلية', 'operative_expenses', '0.00', '0.00', 'group', '2', 21, '2017-10-20 15:10:42'),
(248, 10, 1, '1001', 'Cash on Hand', 'ہاتھ پر نقد', 'النقد في الصندوق', 'cash_hand', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(249, 10, 1, '1002', 'Cash at Bank', 'بینک پر کیش', 'النقدية في البنك', 'cashatbank', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(250, 10, 1, '1003', 'Accounts Receivable', 'وصولی اکاؤنٹس', 'الحسابات المستحقة', 'accounts_receivable', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(251, 10, 1, '1004', 'Inventory', 'انوینٹری', 'المخزون', 'inventory', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(252, 20, 3, '2000', 'Accounts Payable', 'واجب الادا کھاتہ', 'حسابات قابلة للدفع', 'accounts_payable', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(253, 30, 2, '3000', 'Capital', 'کیپٹل', 'عاصمة', 'capital', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(254, 30, 2, '3001', 'Retained Earnings', 'برقرار رکھا کمائی', 'الأرباح المحتجزة', 'retained_earnings', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(255, 40, 5, '4000', 'Sales', 'سیلز', 'مبيعات', 'sales', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(256, 40, 5, '4001', 'Sales Returns and Allowances', 'فروخت کی واپسی اور الاؤنسز', 'عوائد المبيعات والبدلات', 'sales_allowances', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(257, 40, 5, '4002', 'Sales Discounts', 'سیلز ڈسکاؤنٹس', 'تخفيض المبيعات', 'sales_discounts', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(258, 40, 5, '4003', 'Forex Gain Account', 'فاریکس حاصل', '', 'forex_gain_acc_code', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(259, 50, 6, '5000', 'Cost of Sales', 'فروخت کی قیمت', '', 'cost_sales', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(260, 50, 6, '5001', 'Purchases', 'خریداری', '', 'purchases_purchases', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(261, 50, 6, '5002', 'Purchase Returns and Allowances', 'خریداری واپسی اور الاؤنسز', '', 'purchase_allowances', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(262, 50, 6, '5003', 'Purchase Discounts', 'خریداری ڈسکاؤنٹس', '', 'purchase_discounts', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(263, 60, 4, '6000', 'Office Expense', 'آفس کے اخراجات', '', 'office_expense', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(264, 60, 4, '6001', 'Salaries Expense', 'تنخواہوں اخراجات', '', 'salaries_expense', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(265, 60, 4, '6002', 'Forex Loss Account', 'فاریکس نقصان', '', 'forex_loss_acc_code', '0.00', '0.00', 'detail', '3', 21, '2017-10-20 15:10:42'),
(266, 20, 3, '2001', 'Bank of Khyber Loan', 'Bank of Khyber Loan', '', 'BOK Loan', '0.00', '0.00', 'detail', '3', 21, '2017-10-22 18:03:05'),
(268, 30, 2, '3002', 'Drawing', 'Drawing', '', 'Drawing', '0.00', '0.00', 'detail', '3', 21, '2017-10-28 17:29:30'),
(273, 60, 4, '6003', 'Home Expense', 'Home Expense', '', 'Home', '0.00', '0.00', 'detail', '3', 21, '2017-10-28 17:45:25'),
(274, 60, 4, '6004', 'Shop Rent', 'Shop Rent', '', 'Shop Rent', '0.00', '0.00', 'detail', '3', 21, '2017-10-28 17:48:40'),
(276, 60, 4, '6005', 'Security Fees', 'Security Fees', '', 'Security Fees', '0.00', '0.00', 'detail', '3', 21, '2017-10-28 17:49:49'),
(277, 60, 4, '6006', 'Electracity Bill', 'Electracity Bill', '', 'Electracity Bill', '0.00', '0.00', 'detail', '3', 21, '2017-10-28 17:50:47'),
(278, 50, 6, '5004', 'Carriage In', 'Carriage In', '', 'Carriage In', '0.00', '0.00', 'detail', '3', 21, '2017-10-28 17:57:17'),
(279, 20, 3, '2002', 'Sales Tax ', 'سیلز ٹیکس واجب الدا', '', 'sales tax', '0.00', '0.00', 'detail', '3', 21, '2019-07-27 13:45:54'),
(280, 0, 1, '1', 'Assets', 'اثاثہ جات', '', 'assets', '0.00', '0.00', 'group', '1', 22, '2019-10-30 18:10:11'),
(281, 0, 3, '2', 'Liabilities', 'واجبات', '', 'Liabilities', '0.00', '0.00', 'group', '1', 22, '2019-10-30 18:10:11'),
(282, 0, 2, '3', 'Equity', 'ایکوٹی', '', 'equity', '0.00', '0.00', 'group', '1', 22, '2019-10-30 18:10:11'),
(283, 0, 5, '4', 'Revenue', 'آمدنی', '', 'revenue', '0.00', '0.00', 'group', '1', 22, '2019-10-30 18:10:11'),
(284, 0, 6, '5', 'Cost of Goods Sold', 'فروخت سامان کی قیمت', '', 'cos', '0.00', '0.00', 'group', '1', 22, '2019-10-30 18:10:11'),
(285, 0, 4, '6', 'Expenses', 'اخراجات', '', 'expenses', '0.00', '0.00', 'group', '1', 22, '2019-10-30 18:10:11'),
(286, 1, 1, '10', 'Current Assets', 'موجودہ اثاثہ جات', '', 'current_assets', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(287, 1, 1, '12', 'Fixed Assets', 'مقرر اثاثے', '', 'fixed_assets', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(288, 1, 1, '13', 'Other Assets', 'دیگر اثاثے', '', 'other_assets', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(289, 2, 3, '20', 'Current Liabilities', 'موجودہ قرضوں', '', 'current_liabilities', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(290, 2, 3, '21', 'Long Term Liabilities', 'طویل مدتی واجبات', '', 'long_term_liabilities', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(291, 3, 2, '30', 'Equity Account', 'ایکوئٹی اکاؤنٹ', '', 'equity_account', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(292, 4, 5, '40', 'Revenue Account', 'ریونیو اکاؤنٹ', '', 'revenue_account', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(293, 5, 6, '50', 'Cost of goods sold', 'فروخت سامان کی قیمت', '', 'cogs', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(294, 6, 4, '60', 'Operative Expenses', 'آپریٹو اخراجات', '', 'operative_expenses', '0.00', '0.00', 'group', '2', 22, '2019-10-30 18:10:11'),
(295, 10, 1, '1001', 'Cash on Hand', 'ہاتھ پر نقد', '', 'cash_hand', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(296, 10, 1, '1002', 'Cash at Bank', 'بینک پر کیش', '', 'cashatbank', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(297, 10, 1, '1003', 'Accounts Receivable', 'وصولی اکاؤنٹس', '', 'accounts_receivable', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(298, 10, 1, '1004', 'Inventory', 'انوینٹری', '', 'inventory', '20000.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(299, 20, 3, '2000', 'Accounts Payable', 'واجب الادا کھاتہ', '', 'accounts_payable', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(300, 20, 3, '2001', 'Sales Tax Payable', 'سیلز ٹیکس واجب الدا', '', 'sales_tax', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(301, 30, 2, '3000', 'Capital', 'کیپٹل', '', 'capital', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(302, 30, 2, '3001', 'Retained Earnings', 'برقرار رکھا کمائی', '', 'retained_earnings', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(303, 40, 5, '4000', 'Sales', 'سیلز', '', 'sales', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(304, 40, 5, '4001', 'Sales Returns and Allowances', 'فروخت کی واپسی اور الاؤنسز', '', 'sales_allowances', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(305, 40, 5, '4002', 'Sales Discounts', 'سیلز ڈسکاؤنٹس', '', 'sales_discounts', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(306, 40, 5, '4003', 'Forex Gain Account', 'فاریکس حاصل', '', 'forex_gain_acc_code', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(307, 50, 6, '5000', 'Cost of Sales', 'فروخت کی قیمت', '', 'cost_sales', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(308, 50, 6, '5001', 'Purchases', 'خریداری', '', 'purchases', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(309, 50, 6, '5002', 'Purchase Returns and Allowances', 'خریداری واپسی اور الاؤنسز', '', 'purchase_allowances', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(310, 50, 6, '5003', 'Purchase Discounts', 'خریداری ڈسکاؤنٹس', '', 'purchase_discounts', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(311, 60, 4, '6000', 'Office Expense', 'آفس کے اخراجات', '', 'office_expense', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(312, 60, 4, '6001', 'Salaries Expense', 'تنخواہوں اخراجات', '', 'salaries_expense', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(313, 60, 4, '6002', 'Forex Loss Account', 'فاریکس نقصان', '', 'forex_loss_acc_code', '0.00', '0.00', 'detail', '3', 22, '2019-10-30 18:10:11'),
(314, 0, 1, '1', 'Assets', 'اثاثہ جات', '', 'assets', '0.00', '0.00', 'group', '1', 23, '2019-10-30 18:10:37'),
(315, 0, 3, '2', 'Liabilities', 'واجبات', '', 'Liabilities', '0.00', '0.00', 'group', '1', 23, '2019-10-30 18:10:37'),
(316, 0, 2, '3', 'Equity', 'ایکوٹی', '', 'equity', '0.00', '0.00', 'group', '1', 23, '2019-10-30 18:10:37'),
(317, 0, 5, '4', 'Revenue', 'آمدنی', '', 'revenue', '0.00', '0.00', 'group', '1', 23, '2019-10-30 18:10:37'),
(318, 0, 6, '5', 'Cost of Goods Sold', 'فروخت سامان کی قیمت', '', 'cos', '0.00', '0.00', 'group', '1', 23, '2019-10-30 18:10:37'),
(319, 0, 4, '6', 'Expenses', 'اخراجات', '', 'expenses', '0.00', '0.00', 'group', '1', 23, '2019-10-30 18:10:37'),
(320, 1, 1, '10', 'Current Assets', 'موجودہ اثاثہ جات', '', 'current_assets', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(321, 1, 1, '12', 'Fixed Assets', 'مقرر اثاثے', '', 'fixed_assets', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(322, 1, 1, '13', 'Other Assets', 'دیگر اثاثے', '', 'other_assets', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(323, 2, 3, '20', 'Current Liabilities', 'موجودہ قرضوں', '', 'current_liabilities', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(324, 2, 3, '21', 'Long Term Liabilities', 'طویل مدتی واجبات', '', 'long_term_liabilities', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(325, 3, 2, '30', 'Equity Account', 'ایکوئٹی اکاؤنٹ', '', 'equity_account', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(326, 4, 5, '40', 'Revenue Account', 'ریونیو اکاؤنٹ', '', 'revenue_account', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(327, 5, 6, '50', 'Cost of goods sold', 'فروخت سامان کی قیمت', '', 'cogs', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(328, 6, 4, '60', 'Operative Expenses', 'آپریٹو اخراجات', '', 'operative_expenses', '0.00', '0.00', 'group', '2', 23, '2019-10-30 18:10:37'),
(329, 10, 1, '1001', 'Cash on Hand', 'ہاتھ پر نقد', '', 'cash_hand', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(330, 10, 1, '1002', 'Cash at Bank', 'بینک پر کیش', '', 'cashatbank', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(331, 10, 1, '1003', 'Accounts Receivable', 'وصولی اکاؤنٹس', '', 'accounts_receivable', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(332, 10, 1, '1004', 'Inventory', 'انوینٹری', '', 'inventory', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(333, 20, 3, '2000', 'Accounts Payable', 'واجب الادا کھاتہ', '', 'accounts_payable', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(334, 20, 3, '2001', 'Sales Tax Payable', 'سیلز ٹیکس واجب الدا', '', 'sales_tax', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(335, 30, 2, '3000', 'Capital', 'کیپٹل', '', 'capital', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(336, 30, 2, '3001', 'Retained Earnings', 'برقرار رکھا کمائی', '', 'retained_earnings', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(337, 40, 5, '4000', 'Sales', 'سیلز', '', 'sales', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(338, 40, 5, '4001', 'Sales Returns and Allowances', 'فروخت کی واپسی اور الاؤنسز', '', 'sales_allowances', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(339, 40, 5, '4002', 'Sales Discounts', 'سیلز ڈسکاؤنٹس', '', 'sales_discounts', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(340, 40, 5, '4003', 'Forex Gain Account', 'فاریکس حاصل', '', 'forex_gain_acc_code', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(341, 50, 6, '5000', 'Cost of Sales', 'فروخت کی قیمت', '', 'cost_sales', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(342, 50, 6, '5001', 'Purchases', 'خریداری', '', 'purchases', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(343, 50, 6, '5002', 'Purchase Returns and Allowances', 'خریداری واپسی اور الاؤنسز', '', 'purchase_allowances', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(344, 50, 6, '5003', 'Purchase Discounts', 'خریداری ڈسکاؤنٹس', '', 'purchase_discounts', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(345, 60, 4, '6000', 'Office Expense', 'آفس کے اخراجات', '', 'office_expense', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(346, 60, 4, '6001', 'Salaries Expense', 'تنخواہوں اخراجات', '', 'salaries_expense', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(347, 60, 4, '6002', 'Forex Loss Account', 'فاریکس نقصان', '', 'forex_loss_acc_code', '0.00', '0.00', 'detail', '3', 23, '2019-10-30 18:10:37'),
(348, 0, 1, '1', 'Assets', 'اثاثہ جات', '', 'assets', '0.00', '0.00', 'group', '1', 24, '2019-10-30 18:10:41'),
(349, 0, 3, '2', 'Liabilities', 'واجبات', '', 'Liabilities', '0.00', '0.00', 'group', '1', 24, '2019-10-30 18:10:41'),
(350, 0, 2, '3', 'Equity', 'ایکوٹی', '', 'equity', '0.00', '0.00', 'group', '1', 24, '2019-10-30 18:10:41'),
(351, 0, 5, '4', 'Revenue', 'آمدنی', '', 'revenue', '0.00', '0.00', 'group', '1', 24, '2019-10-30 18:10:41'),
(352, 0, 6, '5', 'Cost of Goods Sold', 'فروخت سامان کی قیمت', '', 'cos', '0.00', '0.00', 'group', '1', 24, '2019-10-30 18:10:41'),
(353, 0, 4, '6', 'Expenses', 'اخراجات', '', 'expenses', '0.00', '0.00', 'group', '1', 24, '2019-10-30 18:10:41'),
(354, 1, 1, '10', 'Current Assets', 'موجودہ اثاثہ جات', '', 'current_assets', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(355, 1, 1, '12', 'Fixed Assets', 'مقرر اثاثے', '', 'fixed_assets', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(356, 1, 1, '13', 'Other Assets', 'دیگر اثاثے', '', 'other_assets', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(357, 2, 3, '20', 'Current Liabilities', 'موجودہ قرضوں', '', 'current_liabilities', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(358, 2, 3, '21', 'Long Term Liabilities', 'طویل مدتی واجبات', '', 'long_term_liabilities', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(359, 3, 2, '30', 'Equity Account', 'ایکوئٹی اکاؤنٹ', '', 'equity_account', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(360, 4, 5, '40', 'Revenue Account', 'ریونیو اکاؤنٹ', '', 'revenue_account', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(361, 5, 6, '50', 'Cost of goods sold', 'فروخت سامان کی قیمت', '', 'cogs', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(362, 6, 4, '60', 'Operative Expenses', 'آپریٹو اخراجات', '', 'operative_expenses', '0.00', '0.00', 'group', '2', 24, '2019-10-30 18:10:41'),
(363, 10, 1, '1001', 'Cash on Hand', 'ہاتھ پر نقد', '', 'cash_hand', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(364, 10, 1, '1002', 'Cash at Bank', 'بینک پر کیش', '', 'cashatbank', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(365, 10, 1, '1003', 'Accounts Receivable', 'وصولی اکاؤنٹس', '', 'accounts_receivable', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(366, 10, 1, '1004', 'Inventory', 'انوینٹری', '', 'inventory', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(367, 20, 3, '2000', 'Accounts Payable', 'واجب الادا کھاتہ', '', 'accounts_payable', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(368, 20, 3, '2001', 'Sales Tax Payable', 'سیلز ٹیکس واجب الدا', '', 'sales_tax', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(369, 30, 2, '3000', 'Capital', 'کیپٹل', '', 'capital', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(370, 30, 2, '3001', 'Retained Earnings', 'برقرار رکھا کمائی', '', 'retained_earnings', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(371, 40, 5, '4000', 'Sales', 'سیلز', '', 'sales', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(372, 40, 5, '4001', 'Sales Returns and Allowances', 'فروخت کی واپسی اور الاؤنسز', '', 'sales_allowances', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(373, 40, 5, '4002', 'Sales Discounts', 'سیلز ڈسکاؤنٹس', '', 'sales_discounts', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(374, 40, 5, '4003', 'Forex Gain Account', 'فاریکس حاصل', '', 'forex_gain_acc_code', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(375, 50, 6, '5000', 'Cost of Sales', 'فروخت کی قیمت', '', 'cost_sales', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(376, 50, 6, '5001', 'Purchases', 'خریداری', '', 'purchases', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(377, 50, 6, '5002', 'Purchase Returns and Allowances', 'خریداری واپسی اور الاؤنسز', '', 'purchase_allowances', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(378, 50, 6, '5003', 'Purchase Discounts', 'خریداری ڈسکاؤنٹس', '', 'purchase_discounts', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(379, 60, 4, '6000', 'Office Expense', 'آفس کے اخراجات', '', 'office_expense', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(380, 60, 4, '6001', 'Salaries Expense', 'تنخواہوں اخراجات', '', 'salaries_expense', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(381, 60, 4, '6002', 'Forex Loss Account', 'فاریکس نقصان', '', 'forex_loss_acc_code', '0.00', '0.00', 'detail', '3', 24, '2019-10-30 18:10:41'),
(382, 0, 1, '1', 'Assets', 'اثاثہ جات', '', 'assets', '0.00', '0.00', 'group', '1', 25, '2019-10-30 18:10:45'),
(383, 0, 3, '2', 'Liabilities', 'واجبات', '', 'Liabilities', '0.00', '0.00', 'group', '1', 25, '2019-10-30 18:10:45'),
(384, 0, 2, '3', 'Equity', 'ایکوٹی', '', 'equity', '0.00', '0.00', 'group', '1', 25, '2019-10-30 18:10:45'),
(385, 0, 5, '4', 'Revenue', 'آمدنی', '', 'revenue', '0.00', '0.00', 'group', '1', 25, '2019-10-30 18:10:45'),
(386, 0, 6, '5', 'Cost of Goods Sold', 'فروخت سامان کی قیمت', '', 'cos', '0.00', '0.00', 'group', '1', 25, '2019-10-30 18:10:45'),
(387, 0, 4, '6', 'Expenses', 'اخراجات', '', 'expenses', '0.00', '0.00', 'group', '1', 25, '2019-10-30 18:10:45'),
(388, 1, 1, '10', 'Current Assets', 'موجودہ اثاثہ جات', '', 'current_assets', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(389, 1, 1, '12', 'Fixed Assets', 'مقرر اثاثے', '', 'fixed_assets', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(390, 1, 1, '13', 'Other Assets', 'دیگر اثاثے', '', 'other_assets', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(391, 2, 3, '20', 'Current Liabilities', 'موجودہ قرضوں', '', 'current_liabilities', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(392, 2, 3, '21', 'Long Term Liabilities', 'طویل مدتی واجبات', '', 'long_term_liabilities', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(393, 3, 2, '30', 'Equity Account', 'ایکوئٹی اکاؤنٹ', '', 'equity_account', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(394, 4, 5, '40', 'Revenue Account', 'ریونیو اکاؤنٹ', '', 'revenue_account', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(395, 5, 6, '50', 'Cost of goods sold', 'فروخت سامان کی قیمت', '', 'cogs', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(396, 6, 4, '60', 'Operative Expenses', 'آپریٹو اخراجات', '', 'operative_expenses', '0.00', '0.00', 'group', '2', 25, '2019-10-30 18:10:45'),
(397, 10, 1, '1001', 'Cash on Hand', 'ہاتھ پر نقد', '', 'cash_hand', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(398, 10, 1, '1002', 'Cash at Bank', 'بینک پر کیش', '', 'cashatbank', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(399, 10, 1, '1003', 'Accounts Receivable', 'وصولی اکاؤنٹس', '', 'accounts_receivable', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(400, 10, 1, '1004', 'Inventory', 'انوینٹری', '', 'inventory', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(401, 20, 3, '2000', 'Accounts Payable', 'واجب الادا کھاتہ', '', 'accounts_payable', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(402, 20, 3, '2001', 'Sales Tax Payable', 'سیلز ٹیکس واجب الدا', '', 'sales_tax', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(403, 30, 2, '3000', 'Capital', 'کیپٹل', '', 'capital', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(404, 30, 2, '3001', 'Retained Earnings', 'برقرار رکھا کمائی', '', 'retained_earnings', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(405, 40, 5, '4000', 'Sales', 'سیلز', '', 'sales', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(406, 40, 5, '4001', 'Sales Returns and Allowances', 'فروخت کی واپسی اور الاؤنسز', '', 'sales_allowances', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(407, 40, 5, '4002', 'Sales Discounts', 'سیلز ڈسکاؤنٹس', '', 'sales_discounts', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(408, 40, 5, '4003', 'Forex Gain Account', 'فاریکس حاصل', '', 'forex_gain_acc_code', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(409, 50, 6, '5000', 'Cost of Sales', 'فروخت کی قیمت', '', 'cost_sales', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(410, 50, 6, '5001', 'Purchases', 'خریداری', '', 'purchases', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(411, 50, 6, '5002', 'Purchase Returns and Allowances', 'خریداری واپسی اور الاؤنسز', '', 'purchase_allowances', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(412, 50, 6, '5003', 'Purchase Discounts', 'خریداری ڈسکاؤنٹس', '', 'purchase_discounts', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(413, 60, 4, '6000', 'Office Expense', 'آفس کے اخراجات', '', 'office_expense', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(414, 60, 4, '6001', 'Salaries Expense', 'تنخواہوں اخراجات', '', 'salaries_expense', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(415, 60, 4, '6002', 'Forex Loss Account', 'فاریکس نقصان', '', 'forex_loss_acc_code', '0.00', '0.00', 'detail', '3', 25, '2019-10-30 18:10:45'),
(416, 0, 1, '1', 'Assets', 'اثاثہ جات', '', 'assets', '0.00', '0.00', 'group', '1', 26, '2019-10-30 18:10:48'),
(417, 0, 3, '2', 'Liabilities', 'واجبات', '', 'Liabilities', '0.00', '0.00', 'group', '1', 26, '2019-10-30 18:10:48'),
(418, 0, 2, '3', 'Equity', 'ایکوٹی', '', 'equity', '0.00', '0.00', 'group', '1', 26, '2019-10-30 18:10:48'),
(419, 0, 5, '4', 'Revenue', 'آمدنی', '', 'revenue', '0.00', '0.00', 'group', '1', 26, '2019-10-30 18:10:48'),
(420, 0, 6, '5', 'Cost of Goods Sold', 'فروخت سامان کی قیمت', '', 'cos', '0.00', '0.00', 'group', '1', 26, '2019-10-30 18:10:48'),
(421, 0, 4, '6', 'Expenses', 'اخراجات', '', 'expenses', '0.00', '0.00', 'group', '1', 26, '2019-10-30 18:10:48'),
(422, 1, 1, '10', 'Current Assets', 'موجودہ اثاثہ جات', '', 'current_assets', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(423, 1, 1, '12', 'Fixed Assets', 'مقرر اثاثے', '', 'fixed_assets', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(424, 1, 1, '13', 'Other Assets', 'دیگر اثاثے', '', 'other_assets', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(425, 2, 3, '20', 'Current Liabilities', 'موجودہ قرضوں', '', 'current_liabilities', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(426, 2, 3, '21', 'Long Term Liabilities', 'طویل مدتی واجبات', '', 'long_term_liabilities', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(427, 3, 2, '30', 'Equity Account', 'ایکوئٹی اکاؤنٹ', '', 'equity_account', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(428, 4, 5, '40', 'Revenue Account', 'ریونیو اکاؤنٹ', '', 'revenue_account', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(429, 5, 6, '50', 'Cost of goods sold', 'فروخت سامان کی قیمت', '', 'cogs', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(430, 6, 4, '60', 'Operative Expenses', 'آپریٹو اخراجات', '', 'operative_expenses', '0.00', '0.00', 'group', '2', 26, '2019-10-30 18:10:48'),
(431, 10, 1, '1001', 'Cash on Hand', 'ہاتھ پر نقد', '', 'cash_hand', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(432, 10, 1, '1002', 'Cash at Bank', 'بینک پر کیش', '', 'cashatbank', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(433, 10, 1, '1003', 'Accounts Receivable', 'وصولی اکاؤنٹس', '', 'accounts_receivable', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(434, 10, 1, '1004', 'Inventory', 'انوینٹری', '', 'inventory', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(435, 20, 3, '2000', 'Accounts Payable', 'واجب الادا کھاتہ', '', 'accounts_payable', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(436, 20, 3, '2001', 'Sales Tax Payable', 'سیلز ٹیکس واجب الدا', '', 'sales_tax', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(437, 30, 2, '3000', 'Capital', 'کیپٹل', '', 'capital', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(438, 30, 2, '3001', 'Retained Earnings', 'برقرار رکھا کمائی', '', 'retained_earnings', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(439, 40, 5, '4000', 'Sales', 'سیلز', '', 'sales', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(440, 40, 5, '4001', 'Sales Returns and Allowances', 'فروخت کی واپسی اور الاؤنسز', '', 'sales_allowances', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(441, 40, 5, '4002', 'Sales Discounts', 'سیلز ڈسکاؤنٹس', '', 'sales_discounts', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(442, 40, 5, '4003', 'Forex Gain Account', 'فاریکس حاصل', '', 'forex_gain_acc_code', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(443, 50, 6, '5000', 'Cost of Sales', 'فروخت کی قیمت', '', 'cost_sales', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(444, 50, 6, '5001', 'Purchases', 'خریداری', '', 'purchases', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(445, 50, 6, '5002', 'Purchase Returns and Allowances', 'خریداری واپسی اور الاؤنسز', '', 'purchase_allowances', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(446, 50, 6, '5003', 'Purchase Discounts', 'خریداری ڈسکاؤنٹس', '', 'purchase_discounts', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(447, 60, 4, '6000', 'Office Expense', 'آفس کے اخراجات', '', 'office_expense', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(448, 60, 4, '6001', 'Salaries Expense', 'تنخواہوں اخراجات', '', 'salaries_expense', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(449, 60, 4, '6002', 'Forex Loss Account', 'فاریکس نقصان', '', 'forex_loss_acc_code', '0.00', '0.00', 'detail', '3', 26, '2019-10-30 18:10:48'),
(450, 10, 1, '1007', 'Work in Progress', 'wip', '', 'wip', '0.00', '0.00', 'detail', '3', 21, '2020-08-09 14:55:48'),
(451, 10, 1, '1008', 'Raw Materials', 'Raw', '', 'raw', '0.00', '0.00', 'detail', '3', 21, '2020-10-04 13:14:32'),
(452, 0, 1, '1', 'Assets', 'اثاثہ جات', '', 'assets', '0.00', '0.00', 'group', '1', 22, '2020-10-25 07:10:56'),
(453, 0, 3, '2', 'Liabilities', 'واجبات', '', 'Liabilities', '0.00', '0.00', 'group', '1', 22, '2020-10-25 07:10:56'),
(454, 0, 2, '3', 'Equity', 'ایکوٹی', '', 'equity', '0.00', '0.00', 'group', '1', 22, '2020-10-25 07:10:56'),
(455, 0, 5, '4', 'Revenue', 'آمدنی', '', 'revenue', '0.00', '0.00', 'group', '1', 22, '2020-10-25 07:10:56'),
(456, 0, 6, '5', 'Cost of Goods Sold', 'فروخت سامان کی قیمت', '', 'cos', '0.00', '0.00', 'group', '1', 22, '2020-10-25 07:10:56'),
(457, 0, 4, '6', 'Expenses', 'اخراجات', '', 'expenses', '0.00', '0.00', 'group', '1', 22, '2020-10-25 07:10:56'),
(458, 1, 1, '10', 'Current Assets', 'موجودہ اثاثہ جات', '', 'current_assets', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(459, 1, 1, '12', 'Fixed Assets', 'مقرر اثاثے', '', 'fixed_assets', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(460, 1, 1, '13', 'Other Assets', 'دیگر اثاثے', '', 'other_assets', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(461, 2, 3, '20', 'Current Liabilities', 'موجودہ قرضوں', '', 'current_liabilities', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(462, 2, 3, '21', 'Long Term Liabilities', 'طویل مدتی واجبات', '', 'long_term_liabilities', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(463, 3, 2, '30', 'Equity Account', 'ایکوئٹی اکاؤنٹ', '', 'equity_account', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(464, 4, 5, '40', 'Revenue Account', 'ریونیو اکاؤنٹ', '', 'revenue_account', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(465, 5, 6, '50', 'Cost of goods sold', 'فروخت سامان کی قیمت', '', 'cogs', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(466, 6, 4, '60', 'Operative Expenses', 'آپریٹو اخراجات', '', 'operative_expenses', '0.00', '0.00', 'group', '2', 22, '2020-10-25 07:10:56'),
(467, 10, 1, '1001', 'Cash on Hand', 'ہاتھ پر نقد', '', 'cash_hand', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(468, 10, 1, '1002', 'Cash at Bank', 'بینک پر کیش', '', 'cashatbank', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(469, 10, 1, '1003', 'Accounts Receivable', 'وصولی اکاؤنٹس', '', 'accounts_receivable', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(470, 10, 1, '1004', 'Inventory', 'انوینٹری', '', 'inventory', '20000.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(471, 20, 3, '2000', 'Accounts Payable', 'واجب الادا کھاتہ', '', 'accounts_payable', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(472, 20, 3, '2001', 'Sales Tax Payable', 'سیلز ٹیکس واجب الدا', '', 'sales_tax', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(473, 30, 2, '3000', 'Capital', 'کیپٹل', '', 'capital', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(474, 30, 2, '3001', 'Retained Earnings', 'برقرار رکھا کمائی', '', 'retained_earnings', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(475, 40, 5, '4000', 'Sales', 'سیلز', '', 'sales', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(476, 40, 5, '4001', 'Sales Returns and Allowances', 'فروخت کی واپسی اور الاؤنسز', '', 'sales_allowances', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(477, 40, 5, '4002', 'Sales Discounts', 'سیلز ڈسکاؤنٹس', '', 'sales_discounts', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(478, 40, 5, '4003', 'Forex Gain Account', 'فاریکس حاصل', '', 'forex_gain_acc_code', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(479, 50, 6, '5000', 'Cost of Sales', 'فروخت کی قیمت', '', 'cost_sales', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(480, 50, 6, '5001', 'Purchases', 'خریداری', '', 'purchases', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(481, 50, 6, '5002', 'Purchase Returns and Allowances', 'خریداری واپسی اور الاؤنسز', '', 'purchase_allowances', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(482, 50, 6, '5003', 'Purchase Discounts', 'خریداری ڈسکاؤنٹس', '', 'purchase_discounts', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(483, 60, 4, '6000', 'Office Expense', 'آفس کے اخراجات', '', 'office_expense', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(484, 60, 4, '6001', 'Salaries Expense', 'تنخواہوں اخراجات', '', 'salaries_expense', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(485, 60, 4, '6002', 'Forex Loss Account', 'فاریکس نقصان', '', 'forex_loss_acc_code', '0.00', '0.00', 'detail', '3', 22, '2020-10-25 07:10:56'),
(486, 40, 5, '4004', 'HR Training ', 'HR Training ', '', 'HR Training ', '0.00', '0.00', 'detail', '3', 21, '2020-11-10 22:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `acc_ledgers`
--

CREATE TABLE `acc_ledgers` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `op_dr_balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `op_cr_balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `type` int(2) NOT NULL DEFAULT '0',
  `reconciliation` int(1) NOT NULL,
  `company_id` int(255) NOT NULL,
  `affects_gross` int(12) DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acc_payments`
--

CREATE TABLE `acc_payments` (
  `id` int(10) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `payment_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(255) NOT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `payment_date` date NOT NULL,
  `description` text,
  `name` varchar(100) NOT NULL,
  `amount` double(10,4) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `tax_rate` decimal(10,3) NOT NULL DEFAULT '0.000',
  `tax_amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `supplier_invoice_no` varchar(100) DEFAULT NULL,
  `entry_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `calendar_days`
--

CREATE TABLE `calendar_days` (
  `id` int(255) NOT NULL,
  `day` date NOT NULL,
  `year` int(255) NOT NULL,
  `month` int(255) NOT NULL,
  `day_of_month` int(244) NOT NULL,
  `day_of_week` int(255) NOT NULL,
  `quarter` int(255) NOT NULL,
  `business_day` tinyint(1) NOT NULL,
  `week_day` tinyint(1) NOT NULL,
  `company_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `date_created` date NOT NULL,
  `fy_start` date NOT NULL,
  `fy_end` date NOT NULL,
  `currency_symbol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` int(10) NOT NULL,
  `cur_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `locked` tinyint(1) NOT NULL,
  `expire` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_zone` varchar(244) COLLATE utf8_unicode_ci NOT NULL,
  `is_multi_currency` tinyint(1) NOT NULL DEFAULT '0',
  `tax_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `email`, `contact_no`, `image`, `status`, `date_created`, `fy_start`, `fy_end`, `currency_symbol`, `currency_id`, `cur_datetime`, `locked`, `expire`, `time_zone`, `is_multi_currency`, `tax_no`) VALUES
(20, 'Khybersoft', 'Deans Trade Center Peshawar', 'ahsankhan50@gmail.com', '03459079213', 'min-logo.jpg', 'active', '0000-00-00', '0000-00-00', '0000-00-00', '', 91, '2017-09-24 02:04:09', 0, '1596622649', 'Asia/Karachi', 1, ''),
(21, 'kasbook', 'Deans Trade Center, Peshawar', 'ahsankhan50@gmail.com', '03119809070', '', 'active', '0000-00-00', '0000-00-00', '0000-00-00', '', 91, '2017-10-20 05:42:29', 1, '1670882149', 'Asia/Karachi', 0, '300420598700003'),
(22, 'test username', 'FF852 Deans Trade Center', 'test@mail.com', '123123123', '', 'active', '0000-00-00', '0000-00-00', '0000-00-00', '', 91, '2020-10-25 07:56:52', 1, '1613980612', 'Asia/Karachi', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `module` varchar(255) NOT NULL,
  `host_ip` varchar(25) NOT NULL,
  `user` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `user_agent` varchar(100) NOT NULL,
  `message_title` varchar(255) NOT NULL,
  `message_desc` text NOT NULL,
  `company_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `date`, `module`, `host_ip`, `user`, `url`, `user_agent`, `message_title`, `message_desc`, `company_id`) VALUES
(1, '2022-01-07 11:25:54', 'Admin', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', 'admin User logged in by admin', 21),
(2, '2022-01-07 11:26:18', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', 'Cash at Bank group updated by admin', 21),
(3, '2022-01-07 11:26:29', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', 'Inventory group updated by admin', 21),
(4, '2022-01-07 11:27:02', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', ' Sales Report Retrieved by admin', 21),
(5, '2022-01-07 11:27:05', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', ' Purchase Report Retrieved by admin', 21),
(6, '2022-01-07 11:27:07', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', ' Trail Balance Report Retrieved by admin', 21),
(7, '2022-01-07 11:27:10', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', ' Pofit & Loss Report Retrieved by admin', 21),
(8, '2022-01-07 11:27:12', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', ' Balance Sheet Retrieved by admin', 21),
(9, '2022-01-07 11:27:14', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', ' Annual Report Retrieved by admin', 21),
(10, '2022-01-07 11:28:14', 'admin', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', 'user id 13 User Deleted by admin', 21),
(11, '2022-01-07 11:28:18', 'admin', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', 'user id 22 User Deleted by admin', 21),
(12, '2022-01-07 11:28:23', 'admin', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', 'user id 23 User Deleted by admin', 21),
(13, '2022-01-07 11:28:28', 'Accounts', '::1', 'admin', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.11', '', ' Fiscal year retrieved by admin', 21);

-- --------------------------------------------------------

--
-- Table structure for table `mfg_bom`
--

CREATE TABLE `mfg_bom` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `component` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `workcentre_added` int(11) NOT NULL DEFAULT '0',
  `loc_code` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `quantity` double NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mfg_bom`
--

INSERT INTO `mfg_bom` (`id`, `item_id`, `component`, `workcentre_added`, `loc_code`, `quantity`, `company_id`, `date_created`, `date_updated`) VALUES
(1, 7, '1', 1, '', 1, 21, '2020-08-09 07:36:00', NULL),
(5, 12, '1', 1, '', 1, 21, '2020-08-09 11:54:33', NULL),
(6, 12, '2', 1, '', 2, 21, '2020-08-09 11:54:41', NULL),
(7, 6, '3', 1, '', 1, 21, '2020-08-09 12:36:10', NULL),
(8, 6, '11', 1, '', 1, 21, '2020-08-09 12:36:25', NULL),
(9, 7, '2', 2, '', 1, 21, '2020-08-10 19:23:08', NULL),
(10, 11, '1', 1, '', 2, 21, '2020-09-13 07:34:30', NULL),
(11, 11, '2', 1, '', 1, 21, '2020-09-13 07:34:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mfg_workcenters`
--

CREATE TABLE `mfg_workcenters` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` char(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mfg_workorders`
--

CREATE TABLE `mfg_workorders` (
  `id` int(11) NOT NULL,
  `wo_ref` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `loc_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `units_reqd` double NOT NULL DEFAULT '1',
  `item_id` int(20) NOT NULL,
  `date` date NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `required_by` date NOT NULL,
  `released_date` date NOT NULL,
  `units_issued` double NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `released` tinyint(1) NOT NULL DEFAULT '0',
  `additional_costs` double NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mfg_wo_costing`
--

CREATE TABLE `mfg_wo_costing` (
  `id` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL,
  `cost_type` tinyint(1) NOT NULL COMMENT '0=labor-cost, 1=overhead-cost',
  `amount` decimal(20,0) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mfg_wo_manufacture`
--

CREATE TABLE `mfg_wo_manufacture` (
  `id` int(11) NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `date_` date NOT NULL,
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mfg_wo_requirements`
--

CREATE TABLE `mfg_wo_requirements` (
  `id` int(11) NOT NULL,
  `workorder_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(20) NOT NULL DEFAULT '0',
  `workcenter_id` int(11) NOT NULL DEFAULT '0',
  `units_req` double NOT NULL DEFAULT '1',
  `unit_cost` double NOT NULL DEFAULT '0',
  `loc_code` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `units_issued` double NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(255) NOT NULL,
  `parent_id` int(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_ur` varchar(50) NOT NULL,
  `title_ar` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `path` varchar(50) NOT NULL,
  `sort` varchar(10) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `parent_id`, `name`, `title`, `title_ur`, `title_ar`, `icon`, `path`, `sort`, `status`) VALUES
(1, 0, 'Dashboard', 'Dashboard', 'ڈیش بورڈ', 'لوحة القيادة', 'icon-home', '#', '', 'active'),
(2, 0, 'pos', 'POS', 'POS', 'POS', 'fa fa-list', '#', '', 'active'),
(3, 0, 'accounts', 'Accounts', 'اکاؤنٹس', 'حسابات', 'fa fa-th-large', '#', '', 'active'),
(4, 0, 'trans', 'Transactions', 'لین دین', 'المعاملات', 'fa fa-exchange', '#', '', 'active'),
(5, 0, 'reports', 'Reports', 'رپورٹیں', 'تقارير', 'fa fa-bar-chart-o fa', '#', '', 'active'),
(6, 0, 'settings', 'Settings', 'ترتیبات', 'الإعدادات', 'fa fa-bar-chart-o fa', '#', '', 'inactive'),
(7, 2, 'Categories', 'Categories', 'اقسام', 'التصنيفات', 'fa fa-table fa-fw', 'Categories', '10', 'active'),
(8, 2, 'Suppliers', 'Suppliers', 'دکاندار', 'الموردين', 'fa fa-table fa-fw', 'Suppliers', '20', 'active'),
(9, 2, 'Items', 'Products & Services', 'مصنوعات اور خدمات', 'المنتجات والخدمات', 'fa fa-files-o fa-fw', 'Items', '40', 'active'),
(10, 2, 'Colors', 'Colors', 'رنگ', 'الألوان', 'fa fa-files-o fa-fw', 'Colors', '50', 'inactive'),
(11, 2, 'Sizes', 'Sizes', 'سائز', 'الأحجام', 'fa fa-edit fa-fw', 'Sizes', '60', 'inactive'),
(12, 4, 'C_receivings', 'Purchases', 'خریداری', 'المشتريات', 'fa fa-edit fa-fw', 'C_receivings/allPurchases', '10', 'active'),
(13, 4, 'C_sales', 'Sales', 'فروخت', 'مبيعات', 'fa fa-files-o fa-fw', 'C_sales/allSales', '20', 'active'),
(14, 3, 'C_groups', 'Chart of Accounts', 'اکاؤنٹس کا چارٹ', 'جدول الحسابات', 'fa fa-files-o fa-fw', 'C_groups', '10', 'active'),
(15, 3, 'C_ledgers', 'Ledgers', '', '', 'fa fa-files-o fa-fw', 'C_ledgers', '20', 'inactive'),
(16, 3, 'C_entries', 'Journal Entries', 'جرنل اندراج', 'إدخالات دفتر اليومية', 'fa fa-files-o fa-fw', 'C_entries', '30', 'active'),
(17, 5, 'C_salesreport', 'Sales Report', 'فروخت رپورٹ', 'تقرير المبيعات', 'fa fa-files-o fa-fw', 'C_salesreport', '10', 'active'),
(18, 5, 'C_receivingsreport', 'Purchase Report', ' خریداری رپورٹ', 'تقرير الشراء', 'fa fa-files-o fa-fw', 'C_receivingsreport', '20', 'active'),
(19, 5, 'C_trial_balance', 'Trial Balance', 'سماعت توازن', 'ميزان المراجعة', 'fa fa-files-o fa-fw', 'C_trial_balance', '30', 'active'),
(20, 6, 'C_fyear', 'Fiscal Year', 'مالی سال', 'السنة المالية', 'fa fa-files-o fa-fw', 'C_fyear', '10', 'inactive'),
(21, 2, 'C_employees', 'Employees', 'ملازمین', 'الموظفين', 'fa fa-files-o fa-fw', 'C_employees', '30', 'active'),
(22, 2, 'C_customers', 'Customers', 'گاهک', 'الزبائن', 'fa fa-files-o fa-fw', 'C_customers', '31', 'active'),
(23, 5, 'C_profitloss', 'Profit & Loss', 'نفع اور نقصان', 'خسارة الأرباح', '', 'C_profitloss', '40', 'active'),
(24, 5, 'C_balancesheet', 'Balance Sheet', 'بیلنس شیٹ', 'ورقة التوازن', '', 'C_balancesheet', '41', 'active'),
(25, 2, 'C_locations', 'Locations', 'مقامات', 'المواقع', '', 'C_locations', '65', 'active'),
(26, 4, 'C_expenses', 'Expenses', 'اخراجات', 'نفقات', 'fa fa-files-o fa-fw', 'C_expenses/allPayments', '30', 'active'),
(27, 5, 'C_yearreport', 'Annual Report', 'سالانہ رپورٹ', 'تقرير سنوي', '', 'C_yearreport', '50', 'active'),
(28, 2, 'C_banking', 'Banking', 'بینک', 'الخدمات المصرفية', '', 'C_banking', '32', 'active'),
(29, 2, 'C_units', 'Units', 'یونٹ', 'الوحدات', '', 'C_units', '55', 'active'),
(30, 2, 'C_eventCalendar', 'Calendar', 'بکنگ / منصوبہ بندی', 'التقويم', '', 'C_eventCalendar', '53', 'active'),
(31, 1, 'C_dashboard', 'View', 'ڈیش بورڈ', 'رأي', '', 'C_dashboard', '10', 'active'),
(32, 2, 'C_areas', 'Employee Area', 'ملازم ایریا', 'منطقة الموظف', '', 'C_areas', '58', 'inactive'),
(33, 0, 'mfg', 'Manufacturing', 'مینوفیکچرنگ', 'تصنيع', 'fa fa-list', '#', '', 'active'),
(34, 33, 'C_workcenters', 'Work Centers', 'کام کے مراکز', 'مراكز العمل', '', 'C_workcenters', '10', 'active'),
(35, 33, 'C_workorders', 'Work Orders', 'کام کے احکامات', 'طلبات العمل', '', 'C_workorders', '15', 'active'),
(36, 33, 'C_billofmaterial', 'Bill of Material', 'اشیا کا حساب', 'فاتورة المواد', '', 'C_billofmaterial', '20', 'active'),
(37, 4, 'C_estimate', 'Estimates', 'فروخت', 'اقتباس', 'fa fa-files-o fa-fw', 'C_estimate/allestimate', '20', 'active'),
(38, 4, 'C_purchaseOrders', 'Purchase Orders', 'خریداری', 'أمر شراء', 'fa fa-edit fa-fw', 'C_purchaseOrders/allPurchaseorders', '10', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `pos_banking`
--

CREATE TABLE `pos_banking` (
  `id` int(20) NOT NULL,
  `bank_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cash_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `acc_holder_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `bank_branch` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `creation_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  `company_id` int(20) DEFAULT NULL,
  `op_balance_dr` decimal(10,4) DEFAULT NULL,
  `op_balance_cr` decimal(10,4) DEFAULT NULL,
  `exchange_rate` decimal(10,4) DEFAULT NULL,
  `currency_id` int(20) DEFAULT NULL,
  `isBank` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pos_banking`
--

INSERT INTO `pos_banking` (`id`, `bank_acc_code`, `cash_acc_code`, `bank_account_no`, `bank_name`, `acc_holder_name`, `bank_branch`, `creation_on`, `status`, `company_id`, `op_balance_dr`, `op_balance_cr`, `exchange_rate`, `currency_id`, `isBank`) VALUES
(1, '1002', '1001', '', 'Meezan bank', '', '', '2019-03-24 18:38:44', 1, 21, '50.6700', '0.0000', NULL, NULL, 1),
(2, '1002', '1001', '', 'MCB bank', '', '', '2020-09-02 18:42:12', 1, 21, '0.0000', '0.0000', NULL, NULL, 1),
(3, '1002', '1001', '', 'MCB bank', '', '', '2020-09-30 18:10:53', 1, 21, '0.0000', '0.0000', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_bank_payments`
--

CREATE TABLE `pos_bank_payments` (
  `id` int(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `bank_id` int(100) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `dueTo_acc_code` varchar(100) NOT NULL,
  `ref_account_id` int(20) DEFAULT '0' COMMENT 'its bank id',
  `debit` double(15,4) NOT NULL,
  `credit` double(15,4) NOT NULL,
  `narration` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `company_id` int(20) NOT NULL,
  `entry_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_bank_payments`
--

INSERT INTO `pos_bank_payments` (`id`, `invoice_no`, `bank_id`, `account_code`, `dueTo_acc_code`, `ref_account_id`, `debit`, `credit`, `narration`, `creation_date`, `date`, `company_id`, `entry_id`) VALUES
(1, 'JV1', 2705, '1003', '1003', 0, 0.0000, 2000.0000, '', '2020-06-01 19:30:58', '2020-06-01', 21, 97),
(2, 'JV1', 1, '1002', '1002', 0, 2000.0000, 0.0000, '', '2020-06-01 19:30:58', '2020-06-01', 21, 97),
(3, 'W1', 1, '1002', '1001', 0, 0.0000, 500.0000, 'withdrawl', '2020-06-03 16:52:33', '2020-06-03', 21, 0),
(4, 'C11', 1, '1002', '1003', 0, 600.0000, 0.0000, '', '2020-06-03 16:54:58', '2020-06-03', 21, 126),
(5, 'C12', 1, '1002', '1003', 0, 400.0000, 0.0000, '', '2020-06-03 16:55:31', '2020-06-02', 21, 127),
(6, 'C13', 1, '1002', '1003', 0, 1000.0000, 0.0000, '', '2020-06-03 16:55:57', '2020-06-03', 21, 128),
(7, 'C14', 1, '1002', '1003', 0, 5000.0000, 0.0000, '', '2020-06-03 16:58:54', '2020-05-31', 21, 129),
(8, 'W15', 2, '1002', '1001', 0, 0.0000, 5000.0000, '', '2020-09-02 18:42:22', '2020-09-02', 21, 0),
(9, 'P23', 1, '1002', '1002', 0, 0.0000, 444.0000, ' ', '2020-11-01 13:59:00', '2020-11-01', 21, 986),
(10, 'P24', 3, '2000', '2000', 0, 0.0000, 500.0000, ' ', '2020-11-01 14:12:26', '2020-11-01', 21, 988),
(11, 'P24', 3, '2000', '2000', 0, 0.0000, 1000.0000, ' ', '2020-11-01 14:12:26', '2020-11-01', 21, 990);

-- --------------------------------------------------------

--
-- Table structure for table `pos_categories`
--

CREATE TABLE `pos_categories` (
  `id` int(100) NOT NULL,
  `company_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `long_desc` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `parent_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_categories`
--

INSERT INTO `pos_categories` (`id`, `company_id`, `name`, `short_desc`, `long_desc`, `status`, `parent_id`) VALUES
(1, 21, 'Cat 1', '', '    ', 'active', 0),
(2, 21, 'Cat 2', '', '    ', 'active', 0),
(3, 21, 'Apple', '', '    ', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_colors`
--

CREATE TABLE `pos_colors` (
  `id` int(100) NOT NULL,
  `company_id` int(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_currencies`
--

CREATE TABLE `pos_currencies` (
  `id` int(11) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(25) DEFAULT NULL,
  `symbol` varchar(25) DEFAULT NULL,
  `thousand_separator` varchar(10) DEFAULT NULL,
  `decimal_separator` varchar(10) DEFAULT NULL,
  `company_id` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_currencies`
--

INSERT INTO `pos_currencies` (`id`, `country`, `name`, `code`, `symbol`, `thousand_separator`, `decimal_separator`, `company_id`, `status`) VALUES
(1, 'Albania', 'Leke', 'ALL', 'Lek', ',', '.', 4, 1),
(2, 'America', 'Dollars', 'USD', '$', ',', '.', 4, 1),
(3, 'Afghanistan', 'Afghanis', 'AF', '؋', ',', '.', 4, 1),
(4, 'Argentina', 'Pesos', 'ARS', '$', ',', '.', 4, 1),
(5, 'Aruba', 'Guilders', 'AWG', 'ƒ', ',', '.', 4, 1),
(6, 'Australia', 'Dollars', 'AUD', '$', ',', '.', 4, 1),
(7, 'Azerbaijan', 'New Manats', 'AZ', 'ман', ',', '.', 4, 1),
(8, 'Bahamas', 'Dollars', 'BSD', '$', ',', '.', 4, 1),
(9, 'Barbados', 'Dollars', 'BBD', '$', ',', '.', 4, 1),
(10, 'Belarus', 'Rubles', 'BYR', 'p.', ',', '.', 4, 1),
(11, 'Belgium', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(12, 'Beliz', 'Dollars', 'BZD', 'BZ$', ',', '.', 4, 1),
(13, 'Bermuda', 'Dollars', 'BMD', '$', ',', '.', 4, 1),
(14, 'Bolivia', 'Bolivianos', 'BOB', '$b', ',', '.', 4, 1),
(15, 'Bosnia and Herzegovina', 'Convertible Marka', 'BAM', 'KM', ',', '.', 4, 1),
(16, 'Botswana', 'Pulas', 'BWP', 'P', ',', '.', 4, 1),
(17, 'Bulgaria', 'Leva', 'BG', 'лв', ',', '.', 4, 1),
(18, 'Brazil', 'Reais', 'BRL', 'R$', ',', '.', 4, 1),
(19, 'Britain (United Kingdom)', 'Pounds', 'GBP', '£', ',', '.', 4, 1),
(20, 'Brunei Darussalam', 'Dollars', 'BND', '$', ',', '.', 4, 1),
(21, 'Cambodia', 'Riels', 'KHR', '៛', ',', '.', 4, 1),
(22, 'Canada', 'Dollars', 'CAD', '$', ',', '.', 4, 1),
(23, 'Cayman Islands', 'Dollars', 'KYD', '$', ',', '.', 4, 1),
(24, 'Chile', 'Pesos', 'CLP', '$', ',', '.', 4, 1),
(25, 'China', 'Yuan Renminbi', 'CNY', '¥', ',', '.', 4, 1),
(26, 'Colombia', 'Pesos', 'COP', '$', ',', '.', 4, 1),
(27, 'Costa Rica', 'Colón', 'CRC', '₡', ',', '.', 4, 1),
(28, 'Croatia', 'Kuna', 'HRK', 'kn', ',', '.', 4, 1),
(29, 'Cuba', 'Pesos', 'CUP', '₱', ',', '.', 4, 1),
(30, 'Cyprus', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(31, 'Czech Republic', 'Koruny', 'CZK', 'Kč', ',', '.', 4, 1),
(32, 'Denmark', 'Kroner', 'DKK', 'kr', ',', '.', 4, 1),
(33, 'Dominican Republic', 'Pesos', 'DOP ', 'RD$', ',', '.', 4, 1),
(34, 'East Caribbean', 'Dollars', 'XCD', '$', ',', '.', 4, 1),
(35, 'Egypt', 'Pounds', 'EGP', '£', ',', '.', 4, 1),
(36, 'El Salvador', 'Colones', 'SVC', '$', ',', '.', 4, 1),
(37, 'England (United Kingdom)', 'Pounds', 'GBP', '£', ',', '.', 4, 1),
(38, 'Euro', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(39, 'Falkland Islands', 'Pounds', 'FKP', '£', ',', '.', 4, 1),
(40, 'Fiji', 'Dollars', 'FJD', '$', ',', '.', 4, 1),
(41, 'France', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(42, 'Ghana', 'Cedis', 'GHC', '¢', ',', '.', 4, 1),
(43, 'Gibraltar', 'Pounds', 'GIP', '£', ',', '.', 4, 1),
(44, 'Greece', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(45, 'Guatemala', 'Quetzales', 'GTQ', 'Q', ',', '.', 4, 1),
(46, 'Guernsey', 'Pounds', 'GGP', '£', ',', '.', 4, 1),
(47, 'Guyana', 'Dollars', 'GYD', '$', ',', '.', 4, 1),
(48, 'Holland (Netherlands)', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(49, 'Honduras', 'Lempiras', 'HNL', 'L', ',', '.', 4, 1),
(50, 'Hong Kong', 'Dollars', 'HKD', '$', ',', '.', 4, 1),
(51, 'Hungary', 'Forint', 'HUF', 'Ft', ',', '.', 4, 1),
(52, 'Iceland', 'Kronur', 'ISK', 'kr', ',', '.', 4, 1),
(53, 'India', 'Rupees', 'INR', 'Rp', ',', '.', 4, 1),
(54, 'Indonesia', 'Rupiahs', 'IDR', 'Rp', ',', '.', 4, 1),
(55, 'Iran', 'Rials', 'IRR', '﷼', ',', '.', 4, 1),
(56, 'Ireland', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(57, 'Isle of Man', 'Pounds', 'IMP', '£', ',', '.', 4, 1),
(58, 'Israel', 'New Shekels', 'ILS', '₪', ',', '.', 4, 1),
(59, 'Italy', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(60, 'Jamaica', 'Dollars', 'JMD', 'J$', ',', '.', 4, 1),
(61, 'Japan', 'Yen', 'JPY', '¥', ',', '.', 4, 1),
(62, 'Jersey', 'Pounds', 'JEP', '£', ',', '.', 4, 1),
(63, 'Kazakhstan', 'Tenge', 'KZT', 'лв', ',', '.', 4, 1),
(64, 'Korea (North)', 'Won', 'KPW', '₩', ',', '.', 4, 1),
(65, 'Korea (South)', 'Won', 'KRW', '₩', ',', '.', 4, 1),
(66, 'Kyrgyzstan', 'Soms', 'KGS', 'лв', ',', '.', 4, 1),
(67, 'Laos', 'Kips', 'LAK', '₭', ',', '.', 4, 1),
(68, 'Latvia', 'Lati', 'LVL', 'Ls', ',', '.', 4, 1),
(69, 'Lebanon', 'Pounds', 'LBP', '£', ',', '.', 4, 1),
(70, 'Liberia', 'Dollars', 'LRD', '$', ',', '.', 4, 1),
(71, 'Liechtenstein', 'Switzerland Francs', 'CHF', 'CHF', ',', '.', 4, 1),
(72, 'Lithuania', 'Litai', 'LTL', 'Lt', ',', '.', 4, 1),
(73, 'Luxembourg', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(74, 'Macedonia', 'Denars', 'MKD', 'ден', ',', '.', 4, 1),
(75, 'Malaysia', 'Ringgits', 'MYR', 'RM', ',', '.', 4, 1),
(76, 'Malta', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(77, 'Mauritius', 'Rupees', 'MUR', '₨', ',', '.', 4, 1),
(78, 'Mexico', 'Pesos', 'MX', '$', ',', '.', 4, 1),
(79, 'Mongolia', 'Tugriks', 'MNT', '₮', ',', '.', 4, 1),
(80, 'Mozambique', 'Meticais', 'MZ', 'MT', ',', '.', 4, 1),
(81, 'Namibia', 'Dollars', 'NAD', '$', ',', '.', 4, 1),
(82, 'Nepal', 'Rupees', 'NPR', '₨', ',', '.', 4, 1),
(83, 'Netherlands Antilles', 'Guilders', 'ANG', 'ƒ', ',', '.', 4, 1),
(84, 'Netherlands', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(85, 'New Zealand', 'Dollars', 'NZD', '$', ',', '.', 4, 1),
(86, 'Nicaragua', 'Cordobas', 'NIO', 'C$', ',', '.', 4, 1),
(87, 'Nigeria', 'Nairas', 'NG', '₦', ',', '.', 4, 1),
(88, 'North Korea', 'Won', 'KPW', '₩', ',', '.', 4, 1),
(89, 'Norway', 'Krone', 'NOK', 'kr', ',', '.', 4, 1),
(90, 'Oman', 'Rials', 'OMR', '﷼', ',', '.', 4, 1),
(91, 'Pakistan', 'Rupees', 'PKR', '₨', ',', '.', 4, 1),
(92, 'Panama', 'Balboa', 'PAB', 'B/.', ',', '.', 4, 1),
(93, 'Paraguay', 'Guarani', 'PYG', 'Gs', ',', '.', 4, 1),
(94, 'Peru', 'Nuevos Soles', 'PE', 'S/.', ',', '.', 4, 1),
(95, 'Philippines', 'Pesos', 'PHP', 'Php', ',', '.', 4, 1),
(96, 'Poland', 'Zlotych', 'PL', 'zł', ',', '.', 4, 1),
(97, 'Qatar', 'Rials', 'QAR', '﷼', ',', '.', 4, 1),
(98, 'Romania', 'New Lei', 'RO', 'lei', ',', '.', 4, 1),
(99, 'Russia', 'Rubles', 'RUB', 'руб', ',', '.', 4, 1),
(100, 'Saint Helena', 'Pounds', 'SHP', '£', ',', '.', 4, 1),
(101, 'Saudi Arabia', 'Riyals', 'SAR', '﷼', ',', '.', 4, 1),
(102, 'Serbia', 'Dinars', 'RSD', 'Дин.', ',', '.', 4, 1),
(103, 'Seychelles', 'Rupees', 'SCR', '₨', ',', '.', 4, 1),
(104, 'Singapore', 'Dollars', 'SGD', '$', ',', '.', 4, 1),
(105, 'Slovenia', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(106, 'Solomon Islands', 'Dollars', 'SBD', '$', ',', '.', 4, 1),
(107, 'Somalia', 'Shillings', 'SOS', 'S', ',', '.', 4, 1),
(108, 'South Africa', 'Rand', 'ZAR', 'R', ',', '.', 4, 1),
(109, 'South Korea', 'Won', 'KRW', '₩', ',', '.', 4, 1),
(110, 'Spain', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(111, 'Sri Lanka', 'Rupees', 'LKR', '₨', ',', '.', 4, 1),
(112, 'Sweden', 'Kronor', 'SEK', 'kr', ',', '.', 4, 1),
(113, 'Switzerland', 'Francs', 'CHF', 'CHF', ',', '.', 4, 1),
(114, 'Suriname', 'Dollars', 'SRD', '$', ',', '.', 4, 1),
(115, 'Syria', 'Pounds', 'SYP', '£', ',', '.', 4, 1),
(116, 'Taiwan', 'New Dollars', 'TWD', 'NT$', ',', '.', 4, 1),
(117, 'Thailand', 'Baht', 'THB', '฿', ',', '.', 4, 1),
(118, 'Trinidad and Tobago', 'Dollars', 'TTD', 'TT$', ',', '.', 4, 1),
(119, 'Turkey', 'Lira', 'TRY', 'TL', ',', '.', 4, 1),
(120, 'Turkey', 'Liras', 'TRL', '£', ',', '.', 4, 1),
(121, 'Tuvalu', 'Dollars', 'TVD', '$', ',', '.', 4, 1),
(122, 'Ukraine', 'Hryvnia', 'UAH', '₴', ',', '.', 4, 1),
(123, 'United Kingdom', 'Pounds', 'GBP', '£', ',', '.', 4, 1),
(124, 'United States of America', 'Dollars', 'USD', '$', ',', '.', 4, 1),
(125, 'Uruguay', 'Pesos', 'UYU', '$U', ',', '.', 4, 1),
(126, 'Uzbekistan', 'Sums', 'UZS', 'лв', ',', '.', 4, 1),
(127, 'Vatican City', 'Euro', 'EUR', '€', ',', '.', 4, 1),
(128, 'Venezuela', 'Bolivares Fuertes', 'VEF', 'Bs', ',', '.', 4, 1),
(129, 'Vietnam', 'Dong', 'VND', '₫', ',', '.', 4, 1),
(130, 'Yemen', 'Rials', 'YER', '﷼', ',', '.', 4, 1),
(131, 'Zimbabwe', 'Zimbabwe Dollars', 'ZWD', 'Z$', ',', '.', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_customers`
--

CREATE TABLE `pos_customers` (
  `id` int(255) NOT NULL,
  `company_id` int(255) NOT NULL,
  `store_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `posting_type_id` int(100) NOT NULL,
  `currency_id` int(10) DEFAULT '0',
  `op_balance_dr` decimal(10,4) DEFAULT '0.0000',
  `op_balance_cr` decimal(10,4) DEFAULT '0.0000',
  `exchange_rate` decimal(10,4) DEFAULT '0.0000',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `acc_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isCustomer` tinyint(1) NOT NULL DEFAULT '1',
  `passport_no` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnic` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `passport_issue_date` date DEFAULT NULL,
  `passport_expiry_date` date DEFAULT NULL,
  `father_name` text COLLATE utf8_unicode_ci,
  `emp_id` int(11) NOT NULL,
  `vat_no` varchar(100) NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_customer_payments`
--

CREATE TABLE `pos_customer_payments` (
  `id` int(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `customer_id` int(100) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `dueTo_acc_code` varchar(100) NOT NULL,
  `ref_account_id` int(20) DEFAULT '0' COMMENT 'its customer id dueTo',
  `debit` double(15,4) NOT NULL,
  `credit` double(15,4) NOT NULL,
  `narration` text,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `exchange_rate` double(10,5) NOT NULL DEFAULT '0.00000',
  `company_id` int(20) NOT NULL,
  `entry_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_customer_payment_history`
--

CREATE TABLE `pos_customer_payment_history` (
  `id` int(20) NOT NULL,
  `customer_id` int(20) NOT NULL,
  `invoice_no` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `sales_invoice_no` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,4) NOT NULL,
  `company_id` int(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_employees`
--

CREATE TABLE `pos_employees` (
  `id` int(255) NOT NULL,
  `company_id` int(255) NOT NULL,
  `salary_acc_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cash_acc_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `hire_date` date DEFAULT NULL,
  `job_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cnic` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_employee_payments`
--

CREATE TABLE `pos_employee_payments` (
  `id` int(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `employee_id` int(100) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `dueTo_acc_code` varchar(100) NOT NULL,
  `debit` double(15,4) NOT NULL,
  `credit` double(15,4) NOT NULL,
  `narration` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `company_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_emp_area`
--

CREATE TABLE `pos_emp_area` (
  `id` int(20) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pos_emp_area`
--

INSERT INTO `pos_emp_area` (`id`, `name`, `description`, `created_on`, `status`, `company_id`) VALUES
(1, 'kohat road', 'asdf', '2018-09-29 17:04:41', 'active', 21);

-- --------------------------------------------------------

--
-- Table structure for table `pos_emp_modules`
--

CREATE TABLE `pos_emp_modules` (
  `id` int(100) NOT NULL,
  `emp_id` int(100) NOT NULL,
  `module_id` int(100) NOT NULL,
  `sub_module` int(20) DEFAULT '0',
  `can_create` tinyint(1) DEFAULT '0',
  `can_update` tinyint(1) DEFAULT '0',
  `can_delete` tinyint(1) DEFAULT '0',
  `createn_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pos_emp_modules`
--

INSERT INTO `pos_emp_modules` (`id`, `emp_id`, `module_id`, `sub_module`, `can_create`, `can_update`, `can_delete`, `createn_on`) VALUES
(84, 2, 1, 0, 0, 0, 0, '2017-09-05 06:54:18'),
(85, 2, 2, 0, 0, 0, 0, '2017-09-05 06:54:18'),
(86, 2, 3, 0, 0, 0, 0, '2017-09-05 06:54:19'),
(87, 2, 4, 0, 0, 0, 0, '2017-09-05 06:54:19'),
(95, 3, 1, 0, 0, 0, 0, '2017-09-05 09:12:17'),
(96, 3, 2, 0, 0, 0, 0, '2017-09-05 09:12:17'),
(97, 3, 3, 0, 0, 0, 0, '2017-09-05 09:12:17'),
(98, 3, 4, 0, 0, 0, 0, '2017-09-05 09:12:17'),
(99, 3, 5, 0, 0, 0, 0, '2017-09-05 09:12:17'),
(100, 1, 1, 0, 0, 0, 0, '2017-09-06 05:49:58'),
(101, 1, 2, 0, 0, 0, 0, '2017-09-06 05:49:58'),
(102, 1, 3, 0, 0, 0, 0, '2017-09-06 05:49:58'),
(103, 1, 4, 0, 0, 0, 0, '2017-09-06 05:49:58'),
(104, 1, 5, 0, 0, 0, 0, '2017-09-06 05:49:58'),
(105, 5, 1, 0, 0, 0, 0, '2017-09-06 07:55:31'),
(106, 5, 2, 0, 0, 0, 0, '2017-09-06 07:55:31'),
(107, 5, 3, 0, 0, 0, 0, '2017-09-06 07:55:31'),
(108, 5, 4, 0, 0, 0, 0, '2017-09-06 07:55:31'),
(109, 5, 5, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(110, 5, 8, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(111, 5, 9, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(112, 5, 11, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(113, 5, 12, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(114, 5, 13, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(115, 5, 14, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(116, 5, 16, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(117, 5, 17, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(118, 5, 18, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(119, 5, 19, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(120, 5, 21, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(121, 5, 22, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(122, 5, 23, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(123, 5, 24, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(124, 5, 25, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(125, 5, 26, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(126, 5, 27, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(127, 5, 28, 0, 0, 0, 0, '2017-09-06 07:55:32'),
(133, 6, 1, 0, 0, 0, 0, '2017-09-06 08:13:00'),
(134, 6, 2, 0, 0, 0, 0, '2017-09-06 08:13:00'),
(135, 6, 3, 0, 0, 0, 0, '2017-09-06 08:13:00'),
(136, 6, 4, 0, 0, 0, 0, '2017-09-06 08:13:00'),
(137, 6, 5, 0, 0, 0, 0, '2017-09-06 08:13:00'),
(138, 7, 1, 0, 0, 0, 0, '2017-09-07 01:53:04'),
(139, 7, 2, 0, 0, 0, 0, '2017-09-07 01:53:04'),
(140, 7, 3, 0, 0, 0, 0, '2017-09-07 01:53:04'),
(141, 7, 4, 0, 0, 0, 0, '2017-09-07 01:53:05'),
(142, 7, 5, 0, 0, 0, 0, '2017-09-07 01:53:05'),
(143, 8, 1, 0, 0, 0, 0, '2017-09-15 02:53:43'),
(144, 8, 2, 0, 0, 0, 0, '2017-09-15 02:53:44'),
(145, 8, 3, 0, 0, 0, 0, '2017-09-15 02:53:44'),
(146, 8, 4, 0, 0, 0, 0, '2017-09-15 02:53:44'),
(147, 8, 5, 0, 0, 0, 0, '2017-09-15 02:53:44'),
(163, 10, 1, 0, 0, 0, 0, '2017-09-24 22:28:29'),
(164, 10, 2, 0, 0, 0, 0, '2017-09-24 22:28:29'),
(165, 10, 3, 0, 0, 0, 0, '2017-09-24 22:28:29'),
(166, 10, 4, 0, 0, 0, 0, '2017-09-24 22:28:30'),
(167, 10, 5, 0, 0, 0, 0, '2017-09-24 22:28:30'),
(168, 11, 1, 0, 0, 0, 0, '2017-09-26 03:02:33'),
(169, 11, 2, 0, 0, 0, 0, '2017-09-26 03:02:33'),
(170, 11, 3, 0, 0, 0, 0, '2017-09-26 03:02:33'),
(171, 11, 4, 0, 0, 0, 0, '2017-09-26 03:02:33'),
(172, 11, 5, 0, 0, 0, 0, '2017-09-26 03:02:33'),
(1053, 14, 1, 0, 0, 0, 0, '2019-10-30 18:11:40'),
(1054, 14, 2, 0, 0, 0, 0, '2019-10-30 18:11:40'),
(1055, 14, 3, 0, 0, 0, 0, '2019-10-30 18:11:40'),
(1056, 14, 4, 0, 0, 0, 0, '2019-10-30 18:11:40'),
(1057, 14, 5, 0, 0, 0, 0, '2019-10-30 18:11:40'),
(1058, 15, 1, 0, 0, 0, 0, '2019-10-30 18:20:49'),
(1059, 15, 2, 0, 0, 0, 0, '2019-10-30 18:20:49'),
(1060, 15, 3, 0, 0, 0, 0, '2019-10-30 18:20:49'),
(1061, 15, 4, 0, 0, 0, 0, '2019-10-30 18:20:49'),
(1062, 15, 5, 0, 0, 0, 0, '2019-10-30 18:20:49'),
(1063, 15, 0, 17, 0, 0, 0, '2019-10-30 18:20:49'),
(1064, 15, 0, 18, 0, 0, 0, '2019-10-30 18:20:49'),
(1065, 15, 0, 19, 0, 0, 0, '2019-10-30 18:20:49'),
(1066, 15, 0, 23, 0, 0, 0, '2019-10-30 18:20:49'),
(1067, 15, 0, 24, 0, 0, 0, '2019-10-30 18:20:49'),
(1068, 15, 0, 9, 0, 0, 0, '2019-10-30 18:20:49'),
(1069, 15, 0, 30, 0, 0, 0, '2019-10-30 18:20:49'),
(1070, 15, 0, 29, 0, 0, 0, '2019-10-30 18:20:49'),
(1071, 15, 0, 11, 0, 0, 0, '2019-10-30 18:20:49'),
(1072, 15, 0, 25, 0, 0, 0, '2019-10-30 18:20:49'),
(1073, 16, 1, 0, 0, 0, 0, '2019-10-30 18:37:16'),
(1074, 17, 1, 0, 0, 0, 0, '2019-10-30 18:41:54'),
(1075, 18, 1, 0, 0, 0, 0, '2019-10-30 18:45:31'),
(1076, 19, 1, 0, 0, 0, 0, '2019-10-30 18:48:24'),
(1077, 19, 0, 31, 0, 0, 0, '2019-10-30 18:48:24'),
(1078, 19, 2, 0, 0, 0, 0, '2019-10-30 18:48:24'),
(1079, 19, 0, 7, 0, 0, 0, '2019-10-30 18:48:24'),
(1080, 19, 0, 8, 0, 0, 0, '2019-10-30 18:48:24'),
(1081, 19, 0, 21, 0, 0, 0, '2019-10-30 18:48:24'),
(1082, 19, 0, 22, 0, 0, 0, '2019-10-30 18:48:25'),
(1083, 19, 0, 28, 0, 0, 0, '2019-10-30 18:48:25'),
(1084, 19, 0, 9, 0, 0, 0, '2019-10-30 18:48:25'),
(1085, 19, 0, 30, 0, 0, 0, '2019-10-30 18:48:25'),
(1086, 19, 0, 29, 0, 0, 0, '2019-10-30 18:48:25'),
(1087, 19, 0, 11, 0, 0, 0, '2019-10-30 18:48:25'),
(1088, 19, 0, 25, 0, 0, 0, '2019-10-30 18:48:25'),
(1089, 19, 3, 0, 0, 0, 0, '2019-10-30 18:48:25'),
(1090, 19, 0, 14, 0, 0, 0, '2019-10-30 18:48:25'),
(1091, 19, 0, 16, 0, 0, 0, '2019-10-30 18:48:25'),
(1092, 19, 4, 0, 0, 0, 0, '2019-10-30 18:48:25'),
(1093, 19, 0, 12, 0, 0, 0, '2019-10-30 18:48:25'),
(1094, 19, 0, 13, 0, 0, 0, '2019-10-30 18:48:25'),
(1095, 19, 0, 26, 0, 0, 0, '2019-10-30 18:48:25'),
(1096, 19, 5, 0, 0, 0, 0, '2019-10-30 18:48:25'),
(1097, 19, 0, 17, 0, 0, 0, '2019-10-30 18:48:25'),
(1098, 19, 0, 18, 0, 0, 0, '2019-10-30 18:48:25'),
(1099, 19, 0, 19, 0, 0, 0, '2019-10-30 18:48:25'),
(1100, 19, 0, 23, 0, 0, 0, '2019-10-30 18:48:25'),
(1101, 19, 0, 24, 0, 0, 0, '2019-10-30 18:48:25'),
(1102, 19, 0, 27, 0, 0, 0, '2019-10-30 18:48:26'),
(1333, 12, 1, 0, 0, 0, 0, '2020-09-30 15:47:04'),
(1334, 12, 0, 31, 0, 0, 0, '2020-09-30 15:47:04'),
(1335, 12, 2, 0, 0, 0, 0, '2020-09-30 15:47:04'),
(1336, 12, 0, 7, 0, 0, 0, '2020-09-30 15:47:04'),
(1337, 12, 0, 8, 0, 0, 0, '2020-09-30 15:47:04'),
(1338, 12, 0, 21, 0, 0, 0, '2020-09-30 15:47:04'),
(1339, 12, 0, 22, 0, 0, 0, '2020-09-30 15:47:04'),
(1340, 12, 0, 28, 0, 0, 0, '2020-09-30 15:47:04'),
(1341, 12, 0, 9, 0, 0, 0, '2020-09-30 15:47:04'),
(1342, 12, 0, 30, 0, 0, 0, '2020-09-30 15:47:04'),
(1343, 12, 0, 29, 0, 0, 0, '2020-09-30 15:47:04'),
(1344, 12, 0, 11, 0, 0, 0, '2020-09-30 15:47:04'),
(1345, 12, 0, 25, 0, 0, 0, '2020-09-30 15:47:04'),
(1346, 12, 3, 0, 0, 0, 0, '2020-09-30 15:47:04'),
(1347, 12, 0, 14, 0, 0, 0, '2020-09-30 15:47:04'),
(1348, 12, 0, 16, 0, 0, 0, '2020-09-30 15:47:04'),
(1349, 12, 4, 0, 0, 0, 0, '2020-09-30 15:47:04'),
(1350, 12, 0, 12, 0, 0, 0, '2020-09-30 15:47:04'),
(1351, 12, 0, 38, 0, 0, 0, '2020-09-30 15:47:04'),
(1352, 12, 0, 13, 0, 0, 0, '2020-09-30 15:47:04'),
(1353, 12, 0, 37, 0, 0, 0, '2020-09-30 15:47:04'),
(1354, 12, 0, 26, 0, 0, 0, '2020-09-30 15:47:04'),
(1355, 12, 5, 0, 0, 0, 0, '2020-09-30 15:47:04'),
(1356, 12, 0, 17, 0, 0, 0, '2020-09-30 15:47:04'),
(1357, 12, 0, 18, 0, 0, 0, '2020-09-30 15:47:04'),
(1358, 12, 0, 19, 0, 0, 0, '2020-09-30 15:47:04'),
(1359, 12, 0, 23, 0, 0, 0, '2020-09-30 15:47:04'),
(1360, 12, 0, 24, 0, 0, 0, '2020-09-30 15:47:04'),
(1361, 12, 0, 27, 0, 0, 0, '2020-09-30 15:47:04'),
(1362, 12, 33, 0, 0, 0, 0, '2020-09-30 15:47:04'),
(1363, 12, 0, 34, 0, 0, 0, '2020-09-30 15:47:04'),
(1364, 12, 0, 35, 0, 0, 0, '2020-09-30 15:47:04'),
(1365, 12, 0, 36, 0, 0, 0, '2020-09-30 15:47:04'),
(1366, 24, 1, 0, 0, 0, 0, '2020-10-25 07:56:52'),
(1367, 24, 0, 31, 0, 0, 0, '2020-10-25 07:56:53'),
(1368, 24, 2, 0, 0, 0, 0, '2020-10-25 07:56:53'),
(1369, 24, 0, 7, 0, 0, 0, '2020-10-25 07:56:53'),
(1370, 24, 0, 8, 0, 0, 0, '2020-10-25 07:56:53'),
(1371, 24, 0, 21, 0, 0, 0, '2020-10-25 07:56:53'),
(1372, 24, 0, 22, 0, 0, 0, '2020-10-25 07:56:53'),
(1373, 24, 0, 28, 0, 0, 0, '2020-10-25 07:56:53'),
(1374, 24, 0, 9, 0, 0, 0, '2020-10-25 07:56:53'),
(1375, 24, 0, 30, 0, 0, 0, '2020-10-25 07:56:54'),
(1376, 24, 0, 29, 0, 0, 0, '2020-10-25 07:56:54'),
(1377, 24, 0, 11, 0, 0, 0, '2020-10-25 07:56:54'),
(1378, 24, 0, 25, 0, 0, 0, '2020-10-25 07:56:54'),
(1379, 24, 3, 0, 0, 0, 0, '2020-10-25 07:56:54'),
(1380, 24, 0, 14, 0, 0, 0, '2020-10-25 07:56:54'),
(1381, 24, 0, 16, 0, 0, 0, '2020-10-25 07:56:54'),
(1382, 24, 4, 0, 0, 0, 0, '2020-10-25 07:56:54'),
(1383, 24, 0, 12, 0, 0, 0, '2020-10-25 07:56:54'),
(1384, 24, 0, 38, 0, 0, 0, '2020-10-25 07:56:54'),
(1385, 24, 0, 13, 0, 0, 0, '2020-10-25 07:56:54'),
(1386, 24, 0, 37, 0, 0, 0, '2020-10-25 07:56:54'),
(1387, 24, 0, 26, 0, 0, 0, '2020-10-25 07:56:54'),
(1388, 24, 5, 0, 0, 0, 0, '2020-10-25 07:56:54'),
(1389, 24, 0, 17, 0, 0, 0, '2020-10-25 07:56:54'),
(1390, 24, 0, 18, 0, 0, 0, '2020-10-25 07:56:54'),
(1391, 24, 0, 19, 0, 0, 0, '2020-10-25 07:56:54'),
(1392, 24, 0, 23, 0, 0, 0, '2020-10-25 07:56:54'),
(1393, 24, 0, 24, 0, 0, 0, '2020-10-25 07:56:54'),
(1394, 24, 0, 27, 0, 0, 0, '2020-10-25 07:56:54'),
(1395, 24, 33, 0, 0, 0, 0, '2020-10-25 07:56:54'),
(1396, 24, 0, 34, 0, 0, 0, '2020-10-25 07:56:54'),
(1397, 24, 0, 35, 0, 0, 0, '2020-10-25 07:56:54'),
(1398, 24, 0, 36, 0, 0, 0, '2020-10-25 07:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `pos_estimate`
--

CREATE TABLE `pos_estimate` (
  `sale_id` int(10) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `company_id` int(255) NOT NULL,
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_date` date NOT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(100) NOT NULL,
  `comment` text NOT NULL,
  `register_mode` varchar(512) DEFAULT NULL,
  `account` varchar(255) NOT NULL COMMENT 'cash or credit',
  `amount_due` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `description` text,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `total_amount` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `total_tax` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `exchange_rate` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `paid` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `currency_id` int(10) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(20) DEFAULT '0',
  `delivery_date` datetime NOT NULL,
  `advance` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_estimate_items`
--

CREATE TABLE `pos_estimate_items` (
  `sale_item_id` int(10) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_sold` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,4) NOT NULL,
  `item_unit_price` decimal(15,4) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `service` tinyint(1) NOT NULL,
  `unit_id` int(20) DEFAULT NULL,
  `currency_id` int(10) DEFAULT NULL,
  `exchange_rate` decimal(10,5) DEFAULT NULL,
  `company_id` int(20) NOT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `tax_id` int(20) NOT NULL DEFAULT '0',
  `tax_rate` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_eventcalendar`
--

CREATE TABLE `pos_eventcalendar` (
  `id` int(20) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `title` varchar(20) NOT NULL,
  `url` varchar(50) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` varchar(20) NOT NULL,
  `event_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_eventcalendar`
--

INSERT INTO `pos_eventcalendar` (`id`, `start`, `end`, `title`, `url`, `created_on`, `company_id`, `event_id`) VALUES
(1, '2018-07-09 12:00:00', '2018-07-10 12:00:00', 'test', NULL, '2018-07-17 18:53:03', '21', NULL),
(2, '2018-07-02 12:00:00', '2018-07-03 12:00:00', 'asdf', NULL, '2018-07-17 18:55:11', '21', NULL),
(4, '2018-07-23 12:00:00', '2018-07-24 12:00:00', 'asdf', NULL, '2018-07-17 19:18:22', '21', NULL),
(6, '2018-07-18 10:00:00', '2018-07-18 06:30:00', 'test', NULL, '2018-07-17 19:26:12', '21', NULL),
(8, '2018-07-11 12:00:00', '2018-07-12 12:00:00', 'book2', NULL, '2018-07-18 18:08:48', '21', NULL),
(9, '2018-07-18 12:00:00', '2018-07-18 05:00:00', 'ddfeex', NULL, '2018-07-18 18:09:14', '21', NULL),
(10, '2018-09-18 12:00:00', '2018-09-19 12:00:00', 'event 1', NULL, '2018-09-18 18:25:27', '21', NULL),
(11, '2020-04-03 04:00:00', '2020-04-03 04:30:00', 'appointment 1', NULL, '2020-04-03 07:49:08', '21', NULL),
(12, '2020-04-03 05:30:00', '2020-04-03 06:00:00', 'appointment 2', NULL, '2020-04-03 07:52:35', '21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pos_inventory`
--

CREATE TABLE `pos_inventory` (
  `trans_id` int(11) NOT NULL,
  `company_id` int(255) NOT NULL,
  `trans_item` int(11) NOT NULL DEFAULT '0',
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_comment` text NOT NULL,
  `trans_inventory` int(11) NOT NULL DEFAULT '0',
  `invoice_no` varchar(20) DEFAULT NULL,
  `cost_price` decimal(10,4) DEFAULT '0.0000',
  `unit_price` decimal(10,4) DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_items`
--

CREATE TABLE `pos_items` (
  `item_id` int(10) NOT NULL,
  `company_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `item_type` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `sku` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `service` tinyint(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_items_company`
--

CREATE TABLE `pos_items_company` (
  `id` int(255) NOT NULL,
  `item_id` int(255) NOT NULL,
  `company_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_items_detail`
--

CREATE TABLE `pos_items_detail` (
  `id` int(255) NOT NULL,
  `barcode` varchar(256) NOT NULL,
  `item_id` int(255) NOT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `item_type` varchar(50) NOT NULL,
  `size_id` int(255) NOT NULL DEFAULT '0',
  `color_id` int(255) NOT NULL DEFAULT '0',
  `quantity` double(15,2) NOT NULL,
  `avg_cost` decimal(20,4) NOT NULL,
  `cost_price` decimal(20,4) NOT NULL,
  `unit_price` decimal(20,4) NOT NULL,
  `tax_id` int(20) DEFAULT '0',
  `re_stock_level` double(20,2) NOT NULL,
  `unit_id` int(20) NOT NULL,
  `location_id` int(100) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `inventory_acc_code` varchar(20) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `wip_acc_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_locations`
--

CREATE TABLE `pos_locations` (
  `id` int(100) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_purchasepostingtypes`
--

CREATE TABLE `pos_purchasepostingtypes` (
  `id` int(100) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inventory_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cash_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bank_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `purchasereturn_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `purchasedis_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `payable_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(100) NOT NULL,
  `forex_gain_acc_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forex_loss_acc_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salestax_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_acc_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pos_purchasepostingtypes`
--

INSERT INTO `pos_purchasepostingtypes` (`id`, `name`, `inventory_acc_code`, `cash_acc_code`, `bank_acc_code`, `purchasereturn_acc_code`, `purchasedis_acc_code`, `payable_acc_code`, `company_id`, `forex_gain_acc_code`, `forex_loss_acc_code`, `salestax_acc_code`, `purchase_acc_code`) VALUES
(1, 'Purchase Posting Type', '1004', '1001', '1002', '5002', '5003', '2000', 21, NULL, NULL, '2002', '5000');

-- --------------------------------------------------------

--
-- Table structure for table `pos_purchase_orders`
--

CREATE TABLE `pos_purchase_orders` (
  `receiving_id` int(10) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(255) NOT NULL,
  `supplier_id` int(10) DEFAULT NULL COMMENT 'ledger_id',
  `supplier_invoice_no` varchar(200) NOT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(100) NOT NULL,
  `comment` text NOT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `account` varchar(255) NOT NULL,
  `register_mode` varchar(200) NOT NULL,
  `receiving_date` date NOT NULL,
  `amount_due` double(10,4) NOT NULL,
  `description` text,
  `discount_value` double(10,4) DEFAULT NULL,
  `total_amount` decimal(10,4) NOT NULL,
  `paid` decimal(10,4) NOT NULL,
  `exchange_rate` decimal(10,5) NOT NULL,
  `currency_id` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_tax` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_purchase_orders_items`
--

CREATE TABLE `pos_purchase_orders_items` (
  `purchase_orders_items_id` int(10) NOT NULL,
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `invoice_no` varchar(100) NOT NULL,
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` double(10,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,4) NOT NULL,
  `item_unit_price` double(15,4) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `unit_id` int(20) DEFAULT NULL,
  `company_id` int(20) NOT NULL,
  `tax_id` int(10) DEFAULT '0',
  `tax_rate` decimal(10,0) DEFAULT '0',
  `service` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings`
--

CREATE TABLE `pos_receivings` (
  `receiving_id` int(10) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(255) NOT NULL,
  `supplier_id` int(10) DEFAULT NULL COMMENT 'ledger_id',
  `supplier_invoice_no` varchar(200) NOT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(100) NOT NULL,
  `comment` text NOT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `account` varchar(255) NOT NULL,
  `register_mode` varchar(200) NOT NULL,
  `receiving_date` date NOT NULL,
  `amount_due` double(10,4) NOT NULL,
  `description` text,
  `discount_value` double(10,4) DEFAULT NULL,
  `total_amount` decimal(10,4) NOT NULL,
  `paid` decimal(10,4) NOT NULL,
  `exchange_rate` decimal(10,5) NOT NULL,
  `currency_id` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_tax` decimal(10,3) NOT NULL,
  `file` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings_items`
--

CREATE TABLE `pos_receivings_items` (
  `receivings_items_id` int(10) NOT NULL,
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `invoice_no` varchar(100) NOT NULL,
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` double(10,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,4) NOT NULL,
  `item_unit_price` double(15,4) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `unit_id` int(20) DEFAULT NULL,
  `company_id` int(20) NOT NULL,
  `tax_id` int(10) DEFAULT '0',
  `tax_rate` decimal(10,0) DEFAULT '0',
  `service` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales`
--

CREATE TABLE `pos_sales` (
  `sale_id` int(10) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `company_id` int(255) NOT NULL,
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_date` date NOT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(100) NOT NULL,
  `comment` text NOT NULL,
  `register_mode` varchar(512) DEFAULT NULL,
  `account` varchar(255) NOT NULL COMMENT 'cash or credit',
  `amount_due` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `description` text,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `total_amount` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `total_tax` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `exchange_rate` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `paid` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `currency_id` int(10) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(20) DEFAULT '0',
  `is_taxable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_salespostingtypes`
--

CREATE TABLE `pos_salespostingtypes` (
  `id` int(100) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inventory_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sales_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cash_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bank_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `receivable_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cos_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `salesreturn_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `salesdis_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(100) NOT NULL,
  `forex_gain_acc_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forex_loss_acc_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salestax_acc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pos_salespostingtypes`
--

INSERT INTO `pos_salespostingtypes` (`id`, `name`, `inventory_acc_code`, `sales_acc_code`, `cash_acc_code`, `bank_acc_code`, `receivable_acc_code`, `cos_acc_code`, `salesreturn_acc_code`, `salesdis_acc_code`, `company_id`, `forex_gain_acc_code`, `forex_loss_acc_code`, `salestax_acc_code`) VALUES
(1, 'Sales Posting Type', '1004', '4000', '1001', '1002', '1003', '5000', '4001', '4002', 21, NULL, NULL, '2002');

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales_items`
--

CREATE TABLE `pos_sales_items` (
  `sale_item_id` int(10) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_sold` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,4) NOT NULL,
  `item_unit_price` decimal(15,4) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `service` tinyint(1) NOT NULL,
  `unit_id` int(20) DEFAULT NULL,
  `currency_id` int(10) DEFAULT NULL,
  `exchange_rate` decimal(10,5) DEFAULT NULL,
  `company_id` int(20) NOT NULL,
  `discount_value` decimal(10,4) DEFAULT NULL,
  `tax_id` int(20) NOT NULL DEFAULT '0',
  `tax_rate` int(20) NOT NULL DEFAULT '0',
  `inventory_acc_code` varchar(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_sizes`
--

CREATE TABLE `pos_sizes` (
  `id` int(100) NOT NULL,
  `company_id` int(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_supplier`
--

CREATE TABLE `pos_supplier` (
  `id` int(255) NOT NULL,
  `company_id` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `posting_type_id` int(100) NOT NULL,
  `currency_id` int(10) DEFAULT '0',
  `op_balance_dr` decimal(10,4) DEFAULT '0.0000',
  `op_balance_cr` decimal(10,4) DEFAULT '0.0000',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exchange_rate` decimal(10,0) DEFAULT '0',
  `acc_code` int(11) DEFAULT NULL,
  `isSupplier` tinyint(1) NOT NULL DEFAULT '1',
  `also_customer` tinyint(1) NOT NULL DEFAULT '0',
  `sale_posting_type_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_supplier_payments`
--

CREATE TABLE `pos_supplier_payments` (
  `id` int(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `supplier_id` int(100) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `dueTo_acc_code` varchar(100) NOT NULL,
  `ref_account_id` int(20) DEFAULT '0' COMMENT 'its supplier id',
  `debit` double(15,4) NOT NULL,
  `credit` double(15,4) NOT NULL,
  `narration` text,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `exchange_rate` decimal(10,5) NOT NULL,
  `company_id` int(20) NOT NULL,
  `entry_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_supplier_payment_history`
--

CREATE TABLE `pos_supplier_payment_history` (
  `id` int(20) NOT NULL,
  `supplier_id` int(20) NOT NULL,
  `invoice_no` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `receiving_invoice_no` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(20,4) NOT NULL,
  `company_id` int(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_taxes`
--

CREATE TABLE `pos_taxes` (
  `id` int(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rate` varchar(50) DEFAULT NULL,
  `description` text,
  `company_id` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_units`
--

CREATE TABLE `pos_units` (
  `id` int(100) NOT NULL,
  `company_id` int(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `sale_report`
-- (See below for the actual view)
--
CREATE TABLE `sale_report` (
`category` varchar(255)
,`item_id` int(10)
,`name` varchar(255)
,`company_id` int(255)
,`invoice_no` varchar(20)
,`quantity_sold` decimal(15,2)
,`item_cost_price` decimal(15,4)
,`item_unit_price` decimal(15,4)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `company_id`, `created_on`, `name`, `role`, `status`) VALUES
(12, 'admin', '21232f297a57a5a743894a0e4a801fc3', 21, '2017-10-20 05:42:29', 'demo', 'admin', 1);

-- --------------------------------------------------------

--
-- Structure for view `sale_report`
--
DROP TABLE IF EXISTS `sale_report`;

CREATE VIEW `sale_report`  AS  select `cat`.`name` AS `category`,`i`.`item_id` AS `item_id`,`i`.`name` AS `name`,`i`.`company_id` AS `company_id`,`st`.`invoice_no` AS `invoice_no`,`st`.`quantity_sold` AS `quantity_sold`,`st`.`item_cost_price` AS `item_cost_price`,`st`.`item_unit_price` AS `item_unit_price` from (`pos_categories` `cat` left join (`pos_items` `i` left join `pos_sales_items` `st` on((`i`.`item_id` = `st`.`item_id`))) on((`cat`.`id` = `i`.`category_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_entries`
--
ALTER TABLE `acc_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `entry_no` (`entry_no`);

--
-- Indexes for table `acc_entry_items`
--
ALTER TABLE `acc_entry_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entry_no` (`entry_no`),
  ADD KEY `account_code` (`account_code`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `entry_id` (`entry_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `ref_account_code` (`ref_account_id`);

--
-- Indexes for table `acc_fiscal_years`
--
ALTER TABLE `acc_fiscal_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `acc_groups`
--
ALTER TABLE `acc_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_code` (`account_code`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `parent_code` (`parent_code`,`account_type_id`);

--
-- Indexes for table `acc_payments`
--
ALTER TABLE `acc_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `locked` (`locked`,`expire`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `mfg_bom`
--
ALTER TABLE `mfg_bom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `component` (`component`),
  ADD KEY `id` (`id`),
  ADD KEY `loc_code` (`loc_code`),
  ADD KEY `item_id` (`item_id`,`loc_code`),
  ADD KEY `workcentre_added` (`workcentre_added`);

--
-- Indexes for table `mfg_workcenters`
--
ALTER TABLE `mfg_workcenters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `mfg_workorders`
--
ALTER TABLE `mfg_workorders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `wo_ref` (`wo_ref`);

--
-- Indexes for table `mfg_wo_costing`
--
ALTER TABLE `mfg_wo_costing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mfg_wo_manufacture`
--
ALTER TABLE `mfg_wo_manufacture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workorder_id` (`workorder_id`);

--
-- Indexes for table `mfg_wo_requirements`
--
ALTER TABLE `mfg_wo_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workorder_id` (`workorder_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `pos_banking`
--
ALTER TABLE `pos_banking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_bank_payments`
--
ALTER TABLE `pos_bank_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_no` (`invoice_no`,`bank_id`,`account_code`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `ref_account_id` (`ref_account_id`);

--
-- Indexes for table `pos_categories`
--
ALTER TABLE `pos_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_colors`
--
ALTER TABLE `pos_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_currencies`
--
ALTER TABLE `pos_currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_customers`
--
ALTER TABLE `pos_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `company_id_2` (`company_id`);

--
-- Indexes for table `pos_customer_payments`
--
ALTER TABLE `pos_customer_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_no` (`invoice_no`,`customer_id`,`account_code`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `ref_account_id` (`ref_account_id`),
  ADD KEY `debit` (`debit`),
  ADD KEY `credit` (`credit`);

--
-- Indexes for table `pos_customer_payment_history`
--
ALTER TABLE `pos_customer_payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_employees`
--
ALTER TABLE `pos_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `ledger_id` (`salary_acc_code`);

--
-- Indexes for table `pos_employee_payments`
--
ALTER TABLE `pos_employee_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_no` (`invoice_no`,`employee_id`,`account_code`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_emp_area`
--
ALTER TABLE `pos_emp_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_emp_modules`
--
ALTER TABLE `pos_emp_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`,`module_id`);

--
-- Indexes for table `pos_estimate`
--
ALTER TABLE `pos_estimate`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pos_estimate_items`
--
ALTER TABLE `pos_estimate_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD KEY `invoice_no` (`invoice_no`,`sale_id`,`item_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_eventcalendar`
--
ALTER TABLE `pos_eventcalendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_inventory`
--
ALTER TABLE `pos_inventory`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `ospos_inventory_ibfk_1` (`trans_item`),
  ADD KEY `ospos_inventory_ibfk_2` (`trans_user`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `invoice_no` (`invoice_no`);

--
-- Indexes for table `pos_items`
--
ALTER TABLE `pos_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `company_id_2` (`company_id`),
  ADD KEY `name` (`name`),
  ADD KEY `sku` (`sku`);

--
-- Indexes for table `pos_items_company`
--
ALTER TABLE `pos_items_company`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `item_id` (`item_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_items_detail`
--
ALTER TABLE `pos_items_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `cost_price` (`cost_price`,`unit_price`),
  ADD KEY `avg_cost` (`avg_cost`),
  ADD KEY `item_code` (`item_code`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `pos_locations`
--
ALTER TABLE `pos_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_purchasepostingtypes`
--
ALTER TABLE `pos_purchasepostingtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_purchase_orders`
--
ALTER TABLE `pos_purchase_orders`
  ADD PRIMARY KEY (`receiving_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pos_purchase_orders_items`
--
ALTER TABLE `pos_purchase_orders_items`
  ADD PRIMARY KEY (`purchase_orders_items_id`),
  ADD KEY `receiving_id` (`receiving_id`,`invoice_no`,`item_id`,`size_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_receivings`
--
ALTER TABLE `pos_receivings`
  ADD PRIMARY KEY (`receiving_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pos_receivings_items`
--
ALTER TABLE `pos_receivings_items`
  ADD PRIMARY KEY (`receivings_items_id`),
  ADD KEY `receiving_id` (`receiving_id`,`invoice_no`,`item_id`,`size_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_sales`
--
ALTER TABLE `pos_sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pos_salespostingtypes`
--
ALTER TABLE `pos_salespostingtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_sales_items`
--
ALTER TABLE `pos_sales_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD KEY `invoice_no` (`invoice_no`,`sale_id`,`item_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_sizes`
--
ALTER TABLE `pos_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pos_supplier`
--
ALTER TABLE `pos_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `acc_code` (`acc_code`);

--
-- Indexes for table `pos_supplier_payments`
--
ALTER TABLE `pos_supplier_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_no` (`invoice_no`,`supplier_id`,`account_code`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `ref_account_id` (`ref_account_id`);

--
-- Indexes for table `pos_supplier_payment_history`
--
ALTER TABLE `pos_supplier_payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_taxes`
--
ALTER TABLE `pos_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_units`
--
ALTER TABLE `pos_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `acc_entries`
--
ALTER TABLE `acc_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `acc_entry_items`
--
ALTER TABLE `acc_entry_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `acc_fiscal_years`
--
ALTER TABLE `acc_fiscal_years`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `acc_groups`
--
ALTER TABLE `acc_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;
--
-- AUTO_INCREMENT for table `acc_payments`
--
ALTER TABLE `acc_payments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `mfg_bom`
--
ALTER TABLE `mfg_bom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `mfg_workcenters`
--
ALTER TABLE `mfg_workcenters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mfg_workorders`
--
ALTER TABLE `mfg_workorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mfg_wo_costing`
--
ALTER TABLE `mfg_wo_costing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mfg_wo_manufacture`
--
ALTER TABLE `mfg_wo_manufacture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mfg_wo_requirements`
--
ALTER TABLE `mfg_wo_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `pos_banking`
--
ALTER TABLE `pos_banking`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pos_bank_payments`
--
ALTER TABLE `pos_bank_payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `pos_categories`
--
ALTER TABLE `pos_categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pos_colors`
--
ALTER TABLE `pos_colors`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_currencies`
--
ALTER TABLE `pos_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `pos_customers`
--
ALTER TABLE `pos_customers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_customer_payments`
--
ALTER TABLE `pos_customer_payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_customer_payment_history`
--
ALTER TABLE `pos_customer_payment_history`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_employees`
--
ALTER TABLE `pos_employees`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_employee_payments`
--
ALTER TABLE `pos_employee_payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_emp_area`
--
ALTER TABLE `pos_emp_area`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pos_emp_modules`
--
ALTER TABLE `pos_emp_modules`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1399;
--
-- AUTO_INCREMENT for table `pos_estimate`
--
ALTER TABLE `pos_estimate`
  MODIFY `sale_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_estimate_items`
--
ALTER TABLE `pos_estimate_items`
  MODIFY `sale_item_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_eventcalendar`
--
ALTER TABLE `pos_eventcalendar`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `pos_inventory`
--
ALTER TABLE `pos_inventory`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_items`
--
ALTER TABLE `pos_items`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_items_company`
--
ALTER TABLE `pos_items_company`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_items_detail`
--
ALTER TABLE `pos_items_detail`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_locations`
--
ALTER TABLE `pos_locations`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_purchasepostingtypes`
--
ALTER TABLE `pos_purchasepostingtypes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pos_purchase_orders`
--
ALTER TABLE `pos_purchase_orders`
  MODIFY `receiving_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_purchase_orders_items`
--
ALTER TABLE `pos_purchase_orders_items`
  MODIFY `purchase_orders_items_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_receivings`
--
ALTER TABLE `pos_receivings`
  MODIFY `receiving_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_receivings_items`
--
ALTER TABLE `pos_receivings_items`
  MODIFY `receivings_items_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_sales`
--
ALTER TABLE `pos_sales`
  MODIFY `sale_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_salespostingtypes`
--
ALTER TABLE `pos_salespostingtypes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pos_sales_items`
--
ALTER TABLE `pos_sales_items`
  MODIFY `sale_item_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_sizes`
--
ALTER TABLE `pos_sizes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_supplier`
--
ALTER TABLE `pos_supplier`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_supplier_payments`
--
ALTER TABLE `pos_supplier_payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_supplier_payment_history`
--
ALTER TABLE `pos_supplier_payment_history`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_taxes`
--
ALTER TABLE `pos_taxes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_units`
--
ALTER TABLE `pos_units`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
