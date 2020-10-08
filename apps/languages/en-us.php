<?php
/*
  InStats
  @yasinkuyu, 2016
*/

$lang = array();

$lang['lang'] = "en-us";
$lang['lang_name'] = "English";

// Global
$lang['reports'] = "Reports";
$lang['stats'] = "Statistics";
$lang['summary'] = "Summary";
$lang['referers'] = "Referers";
$lang['status'] = "Status";
$lang['back'] = "Back to Previous Page";
$lang['path'] = "Path";
$lang['date'] = "Date";
$lang['time'] = "Time";
$lang['hour'] = "Saat";
$lang['year'] = "Year";
$lang['month'] = "Month";
$lang['day'] = "Day";
$lang['week'] = "Week";

// Reports
$lang['page_views'] = "Page Views";
$lang['visitor'] = "Visitor";
$lang['visitors'] = "Visitors";
$lang['today'] = "Today";
$lang['yesterday'] = "Yesterday";
$lang['top_day'] = "Top Day";
$lang['detail_stats'] = "Detailed Statistics";
$lang['detail_reports'] = "detailed reports";
$lang['detail_reports_text'] = "to see the statistics about browsers, resolutions, colors, Operating Systems Pages and Referers";
$lang['admin'] = "Admin";
$lang['admin_page'] = "Admin Page";
$lang['view'] = "View";
$lang['page_views_ap'] = "page views for all pages";
$lang['report_ref'] = "all referers";
$lang['reportpathy'] = "time specific page views";
$lang['report_ips'] = " click paths (ip addresses)";
$lang['graphs'] = "Graphs";
$lang['graphs_hour'] = "Page Views and Visitors by Hour";
$lang['graphs_dow'] = "Page Views and Visitors by Day of Week";
$lang['graphs_dom'] = "Page Views and Visitors by Day of Month";
$lang['graphs_week'] = "Page Views and Visitors by Week of Year";
$lang['graphs_month'] = "Page Views and Visitors by Month";
$lang['graphs_year'] = "Page Views and Visitors by Year";
$lang['weekdays'] = "Mon, Tue, Wed, Thu, Fri, Sat, Sun";
$lang['months'] = "January,February,March,April,May,June,July,August,September,October,November,December";
$lang['go'] = "Go";

$lang['year_stats'] = "Yearly Page Views & Unique Visitors";
$lang['daily_reports'] = "Daily Page Views & Unique Visitors for";

$lang['yearly'] = "Yearly Reports";
$lang['monthly'] = "Monhly Reports";
$lang['daily'] = "Daily Reports";
$lang['hourly'] = "Hourly Reports";
$lang["top_ten_page"] = "Top 10 Page";
$lang["top_ten_ref"] = "Top 10 Referers";
$lang["browsers"] = "browsers";
$lang["resolutions"] = "resolutions";
$lang["colors"] = "colors";
$lang["oses"] = "Operating Systems";
$lang["langs"] = "Langs";
$lang["langname"] = "Lang";
$lang["uagents"] = "User Agents";
$lang["uagentname"] = "User Agent";
$lang["keywords"] = "Keywords";
$lang["keyword"] = "Keyword";
$lang["visitorname"] = "Visitor";

$lang['view_hourly'] = "Hourly Report";
$lang['view_hour'] = "by Hour";
$lang['view_weekly'] = "Day of Week Report";
$lang['view_week'] = "by Day of Week";
$lang['view_daily'] = "Day of Month Report";
$lang['view_day'] = "by Day of Month";
$lang['view_monthly'] = "Monthly Report";
$lang['view_month'] = "by Month";
$lang['view_yearly'] = "Yearly Report";
$lang['view_year'] = "by Year";
$lang['data_display'] = "Displaying Data For";

$lang['view_year_weekly'] = "Week of Year Report";

$lang["pathname"] = "Path Name";
$lang["refname"] = "Referer Name";
$lang["browsername"] = "Browser Adı";
$lang["resname"] = "resolutions Name";
$lang["colorname"] = "Color Name";
$lang["osname"] = "OS Name";
$lang["total"] = "total";

$lang['all_pages'] = "All Pages";
$lang['all_referers'] = "All Referers";
$lang['all_data'] = "all data";

$lang['visitor_reports'] = "Visitor Reports";
$lang['select'] = "Select";

$lang["ask_question"] = "Ask Question";
$lang["error_report"] = "Error Report";
$lang["suggest_feature"] = "Suggest Feature";
$lang["suggest_site"] = "Suggest Site";

// Admin
$lang["update_successfully"] = "Settings updated!";
$lang["update_settings"] = "Update Settings";
$lang["return_reports"] = "Back to Report";
$lang["return_admin"] = "Back to Admin";
$lang["feature"] = "Feature";
$lang["setting"] = "Option";
$lang["desc"] = "Decription";
$lang["on"] = "On";
$lang["off"] = "Off";

$lang["image_location"] = "Image Location";
$lang["image_location_desc"] = "sImageLocation constant defines the location of the image used by InStats.";

$lang["filter_ips"] = "Filtre ip's";
$lang["filter_ips_desc"] = "sFilterIps constant defines ip addresses to filter from stats <br />
reported by InStats. This is useful for webmasters that do <br />
not want their own activity reported in reports.<br />
List IPs separated by commas!";

$lang["show_links"] = "Show Links";
$lang["show_links_desc"] = "Show links in reports as active links.<br />
If true, if a link is shown in a report, it can be clicked<br />
and the browser will display the referring page or viewed page.";

$lang["count_own_server"] = "Count Own Server";
$lang["count_own_server_desc"] = "Count your own server as referer?<br />
If true, the click generated from your<br />
own site will be counted as referers as well.";

$lang["strip_params"] = "Strip pathname Parameters";
$lang["strip_params_desc"] = "Strip off the parameters from the path name?<br />
If on:<br />
http://www.insya.com/index.asp?id=2&cid=4 is stripped to<br />
http://www.insya.com/index.asp";

$lang["strip_protocol"] = "Strip pathname Protocol";
$lang["strip_protocol_desc"] = "Strip off the protocol from the path name?<br />
If on:<br />
http://www.insya.com/index.asp?id=2&cid4 is stripped to<br />
insya.com/index.asp?id=2&cid4";

$lang["strip_ref_params"] = "Strip Referer Parameters";
$lang["strip_ref_params_desc"] = "Strip off the parameters from the referer name?<br />
If on:<br />
http://www.microsoft.com/go.asp?linkid=6 is stripped to<br />
http://www.microsoft.com/go.asp";

$lang["strip_ref_protocol"] = "Strip Referer Protocol";
$lang["strip_ref_protocol_desc"] = "Strip off the protocol from the referer name?<br />
If on:<br />
http://www.microsoft.com/go.asp?linkid=6 is stripped to<br />
microsoft.com/go.asp?linkid=6";

$lang["ref_file"] = "Strip Path&File Referer";
$lang["ref_file_desc"] = "Strip off the path and file name from the referer name?<br />
If on:<br />
http://www.microsoft.com/go.asp?linkid=6 is stripped to<br />
http://www.microsoft.com";

$lang["language"] = "language";
$lang["language_desc"] = "Select display language.";

$lang["clear_data"] = "Clear data";
$lang["clear_data_msg"] = "Are you sure? ";
$lang["clear_data_desc"] = "ATTENTION: all statistics will be deleted.";
$lang["clear_data_success"] = "All statistic data is reset.";

$lang["force_login"] = "Force login";
$lang["force_login_desc"] = "Get user input requiring in order to view the statistics.";

$lang["save"] = "Save";

$lang["username"] = "Username";
$lang["password"] = "Password";
$lang["remember"] = "Remember me";
$lang["login"] = "Login";
$lang["logout"] = "Logout";
$lang["login_desc"] = "To access to the statistics of your site, you must Login.<br>Insert your <b>Username</b> and <b>Password</b> and click on Enter.";
$lang["login_user_banned"] = "You are not logged blocked";
$lang["login_info_wellcome"] = "Welcome, dear ";
$lang["login_info_incorrect"] = "Incorrect username or password blank.";
$lang["login_info_not_empaty"] = "Username or password can not be empty.";
