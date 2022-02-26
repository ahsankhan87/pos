<?php

/**
 * @author lolkittens
 * @copyright 2018
 */

INSERT INTO acc_groups (parent_code, account_type_id, account_code, title, title_ur, name,
                 type, level, company_id, date_created) VALUES                  
                 (0, 1, '1', 'Assets', '????? ???', 'assets', 'group', '1', '2', '2018-03-15 12:18:00'),
                 (0, 3, '2', 'Liabilities', '??????', 'Liabilities', 'group', '1', '2', '2018-03-15 12:18:00'),
                (0, 2, '3', 'Equity', '??????', 'equity', 'group', '1', '2', '2018-03-15 12:18:00'),
                (0, 5, '4', 'Revenue', '?????', 'revenue', 'group', '1', '2', '2018-03-15 12:18:00'),
                (0, 6, '5', 'Cost of Goods Sold', '????? ????? ?? ????', 'cos', 'group', '1', '2', '2018-03-15 12:18:00'),
                (0, 4, '6', 'Expenses', '???????', 'expenses', 'group', '1', '2', '2018-03-15 12:18:00'),
                (1, 1, '10', 'Current Assets', '?????? ????? ???', 'current_assets', 'group', '2', '2', '2018-03-15 12:18:00'),
                (1, 1, '12', 'Fixed Assets', '???? ?????', 'fixed_assets', 'group', '2', '2', '2018-03-15 12:18:00'),
                (1, 1, '13', 'Other Assets', '???? ?????', 'other_assets', 'group', '2', '2', '2018-03-15 12:18:00'),
                (2, 3, '20', 'Current Liabilities', '?????? ?????', 'current_liabilities', 'group', '2', '2', '2018-03-15 12:18:00'),
                (2, 3, '21', 'Long Term Liabilities', '???? ???? ??????', 'long_term_liabilities', 'group', '2', '2', '2018-03-15 12:18:00'),
                (3, 2, '30', 'Equity Account', '??????? ??????', 'equity_account', 'group', '2', '2', '2018-03-15 12:18:00'),
                (4, 5, '40', 'Revenue Account', '?????? ??????', 'revenue_account', 'group', '2', '2', '2018-03-15 12:18:00'),
                (5, 6, '50', 'Cost of goods sold', '????? ????? ?? ????', 'cogs', 'group', '2', '2', '2018-03-15 12:18:00'),
                (6, 4, '60', 'Operative Expenses', '?????? ???????', 'operative_expenses', 'group', '2', '2', '2018-03-15 12:18:00'),
                (10, 1, '1001', 'Cash on Hand', '???? ?? ???', 'cash_hand', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (10, 1, '1002', 'Cash at Bank', '???? ?? ???', 'cashatbank', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (10, 1, '1003', 'Accounts Receivable', '????? ???????', 'accounts_receivable', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (10, 1, '1004', 'Inventory', '????????', 'inventory', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (20, 3, '2000', 'Accounts Payable', '???? ????? ?????', 'accounts_payable', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (30, 2, '3000', 'Capital', '?????', 'capital', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (30, 2, '3001', 'Retained Earnings', '?????? ???? ?????', 'retained_earnings', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (40, 5, '4000', 'Sales', '????', 'sales', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (40, 5, '4001', 'Sales Returns and Allowances', '????? ?? ????? ??? ???????', 'sales_allowances', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (40, 5, '4002', 'Sales Discounts', '???? ????????', 'sales_discounts', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (40, 5, '4003', 'Forex Gain Account', '?????? ????', 'forex_gain_acc_code', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (50, 6, '5000', 'Cost of Sales', '????? ?? ????', 'cost_sales', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (50, 6, '5001', 'Purchases', '???????', 'purchases', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (50, 6, '5002', 'Purchase Returns and Allowances', '??????? ????? ??? ???????', 'purchase_allowances', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (50, 6, '5003', 'Purchase Discounts', '??????? ????????', 'purchase_discounts', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (60, 4, '6000', 'Office Expense', '??? ?? ???????', 'office_expense', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (60, 4, '6001', 'Salaries Expense', '???????? ???????', 'salaries_expense', 'detail', '3', '2', '2018-03-15 12:18:00'),
                (60, 4, '6002', 'Forex Loss Account', '?????? ?????', 'forex_loss_acc_code', 'detail', '3', '2', '2018-03-15 12:18:00')";


?>