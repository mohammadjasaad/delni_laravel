# 📘 Delni.co — Routes Documentation

توثيق كامل لجميع المسارات في موقع **Delni.co** (إعلانات – خدمات – تاكسي – طوارئ – لوحة المستخدم – لوحة المشرف – Auth).

---

## 🌍 الصفحات العامة والثابتة
| Method | URI                | Name            | Controller / View       |
|--------|--------------------|-----------------|-------------------------|
| GET    | /                  | home            | AdController@index      |
| GET    | /about             | about           | View: about             |
| GET    | /privacy           | privacy         | View: pages.privacy     |
| GET    | /terms             | terms           | View: pages.terms       |
| GET    | /faq               | faq             | View: pages.faq         |
| GET    | /contact           | contact         | ContactController@show  |
| POST   | /contact           | contact.send    | ContactController@send  |
| GET    | /logged-out        | logged-out      | View: auth.logged-out   |
| GET    | /change-lang/{lang}| change.lang     | Closure (set session)   |
| GET    | /lang/{locale}     | lang.switch     | Closure (set session)   |
| GET    | /change-language/{lang}| change-language | Redirect to switch |

---

## 📢 الإعلانات
| Method | URI                     | Name          | Controller              |
|--------|-------------------------|---------------|-------------------------|
| GET    | /ads                    | ads.index     | AdController@index      |
| GET    | /ads/create             | ads.create    | AdController@create     |
| POST   | /ads/store              | ads.store     | AdController@store      |
| GET    | /ads/{id}               | ads.show      | AdController@show       |
| POST   | /ads/{id}/favorite      | ads.favorite  | AdController@addFavorite|
| DELETE | /ads/{id}/unfavorite    | ads.unfavorite| AdController@removeFavorite|
| POST   | /ads/{id}/report        | ads.report    | ReportController@store  |

---

## 🚨 خدمات الطوارئ
| Method | URI                         | Name                 | Controller                    |
|--------|-----------------------------|----------------------|--------------------------------|
| GET    | /emergency-services         | emergency.index      | EmergencyServiceController@index |
| GET    | /emergency-services/create  | emergency_services.create | EmergencyServiceController@create |
| POST   | /emergency-services         | emergency_services.store | EmergencyServiceController@store |
| GET    | /emergency-services/{id}    | emergency_services.show | EmergencyServiceController@show |
| GET    | /emergency-services/map-data| emergency_services.mapData | EmergencyServiceController@mapData |
| GET    | /emergency/statistics       | emergency.stats      | EmergencyStatisticsController@index |
| GET    | /emergency-reports          | emergency_reports.index | EmergencyReportController@index |
| POST   | /emergency-reports          | emergency_reports.store | EmergencyReportController@store |
| GET    | /emergency-reports/{id}     | emergency_reports.show | EmergencyReportController@show |
| DELETE | /emergency-reports/{id}     | emergency_reports.destroy | EmergencyReportController@destroy |

---

## 🚖 Delni Taxi
| Method | URI                          | Name                | Controller           |
|--------|------------------------------|---------------------|----------------------|
| GET    | /delni-taxi                  | delni.taxi          | TaxiController@index |
| GET    | /order-taxi                  | order.taxi          | View: order-taxi     |
| GET    | /order-status                | order.status        | OrderController@status |
| GET    | /trip/completed              | trip.completed      | TaxiController@tripCompleted |
| POST   | /taxi/request                | taxi.request        | OrderController@store |
| POST   | /submit-rating               | submit.rating       | RatingController@store |
| POST   | /taxi/order/complete-with-rating | taxi.complete.with.rating | TaxiOrderController@completeWithRating |
| GET    | /taxi/order/{id}/status      | taxi.order.status   | TaxiOrderController@showStatus |
| GET    | /driver/login                | driver.login        | View: taxi.drivers.login |
| GET    | /driver/dashboard            | driver.dashboard    | View: taxi.drivers.panel |
| POST   | /driver/message              | driver.message.store| TaxiMessageController@store |
| GET    | /driver/messages             | driver.message.fetch| TaxiMessageController@fetch |
| GET    | /chat/{order}                | driver.chat         | TaxiMessageController@driverChat |
| POST   | /chat/{order}                | driver.message.reply| TaxiMessageController@driverReply |
| GET    | /taxi/chat/{order_id}        | passenger.chat      | TaxiChatController@showPassengerChat |

---

## 👤 السائقون
| Method | URI                 | Name              | Controller            |
|--------|---------------------|-------------------|-----------------------|
| GET    | /drivers            | drivers.index     | DriverController@index|
| GET    | /drivers/create     | drivers.create    | DriverController@create|
| POST   | /drivers/store      | drivers.store     | DriverController@store|
| GET    | /drivers/{id}       | drivers.show      | DriverController@show |
| GET    | /drivers/{id}/edit  | drivers.edit      | DriverController@edit |
| PUT    | /drivers/{id}       | drivers.update    | DriverController@update|
| DELETE | /drivers/{id}       | drivers.destroy   | DriverController@destroy|
| POST   | /drivers/{id}/status| drivers.updateStatus| DriverController@updateStatus|
| GET    | /drivers/map        | drivers.map       | TaxiDriverController@index |

---

## 📊 لوحة تحكم المستخدم (Dashboard)
| Method | URI                          | Name                      | Controller            |
|--------|------------------------------|---------------------------|-----------------------|
| GET    | /dashboard                   | dashboard.index           | DashboardController@index |
| GET    | /dashboard/myinfo            | dashboard.myinfo          | DashboardController@myInfo |
| GET    | /dashboard/myinfo/edit       | dashboard.myinfo.edit     | DashboardController@editInfo |
| POST   | /dashboard/myinfo/update     | dashboard.myinfo.update   | DashboardController@updateInfo |
| GET    | /dashboard/myads             | dashboard.myads           | DashboardController@myAds |
| GET    | /dashboard/ads/{id}/edit     | dashboard.ads.edit        | AdController@edit |
| PUT    | /dashboard/ads/{id}          | dashboard.ads.update      | AdController@update |
| DELETE | /dashboard/ads/{id}          | dashboard.ads.destroy     | AdController@destroy |
| POST   | /dashboard/ads/{id}/feature  | ads.feature               | AdController@makeFeatured |
| POST   | /dashboard/ads/{id}/unfeature| ads.unfeature             | AdController@removeFeatured |
| GET    | /dashboard/myorders          | dashboard.myorders        | DashboardController@myOrders |
| GET    | /dashboard/user-stats        | dashboard.userstats       | DashboardController@userStats |
| GET    | /dashboard/statistics        | dashboard.statistics      | Dashboard\StatisticsController@index |
| GET    | /dashboard/password/change   | dashboard.password.change | DashboardController@editPassword |
| POST   | /dashboard/password/update   | dashboard.password.update | DashboardController@updatePassword |
| GET    | /dashboard/notifications     | dashboard.notifications  | DashboardController@notifications |
| GET    | /dashboard/favorites         | dashboard.favorites       | FavoriteController@index |

---

## 🛠️ لوحة تحكم المشرف (Admin)
| Method | URI                          | Name                                | Controller                |
|--------|------------------------------|-------------------------------------|---------------------------|
| GET    | /admin                       | admin.dashboard                     | Admin\DashboardController@index |
| GET    | /admin/users                 | admin.users.index                   | Admin\UserController@index |
| POST   | /admin/users/{id}/promote    | admin.users.promote                 | Admin\UserController@promote |
| GET    | /admin/visitors              | admin.visitors.index                | Admin\VisitorController@index |
| GET    | /admin/statistics            | admin.statistics                    | Dashboard\StatisticsController@index |
| GET    | /admin/taxi-orders           | admin.taxi.orders                   | TaxiOrderController@index |
| GET    | /admin/notifications         | admin.notifications                 | AdminController@notifications |
| GET    | /admin/support-tickets       | admin.support_tickets.index         | Admin\SupportTicketAdminController@index |
| GET    | /admin/support-tickets/statistics | admin.support_tickets.statistics | Admin\SupportTicketAdminController@statistics |
| GET    | /admin/support-tickets/{id}  | admin.support_tickets.show          | Admin\SupportTicketAdminController@show |
| PUT    | /admin/support-tickets/{id}  | admin.support_tickets.update        | Admin\SupportTicketAdminController@update |
| GET    | /admin/emergency-dashboard   | admin.emergency_dashboard           | EmergencyReportController@dashboard |
| GET    | /admin/emergency-reports     | admin.emergency_reports.index       | Admin\EmergencyReportController@index |
| GET    | /admin/emergency-reports/{id}| admin.emergency_reports.show        | Admin\EmergencyReportController@show |
| POST   | /admin/emergency-reports/{id}/update-status | admin.emergency_reports.update_status | Admin\EmergencyReportController@updateStatus |
| DELETE | /admin/emergency-reports/{id}| admin.emergency_reports.destroy     | Admin\EmergencyReportController@destroy |
| GET    | /admin/emergency-services    | emergency_services.index            | EmergencyServiceController@index |
| GET    | /admin/emergency-centers     | admin.emergency_centers.index       | AdminEmergencyController@index |
| GET    | /admin/emergency/statistics  | admin.emergency.stats               | EmergencyStatisticsController@index |

---

## 🔐 Auth
- `/login`, `/logout`, `/register`
- `/forgot-password`, `/reset-password/{token}`
- `/verify-email`, `/verify-email/{id}/{hash}`
- `/sanctum/csrf-cookie`

---

## 🧪 صفحات اختبار الأخطاء
- `/test-error-401`  
- `/test-error-403`  
- `/test-error-404`  
- `/test-error-419`  
- `/test-error-422`  
- `/test-error-429`  
- `/test-error-500`  
- `/test-error-503`  
