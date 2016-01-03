<?php
!defined('SERVER_EXEC') && die('No access.');
?>
body {
  color: "@@color500";
}
.user-avatar {
  border-color: "@@color500";
}
#report-tab-navs .report-tab-nav::before {
  background-color: "@@color600";
}
#report-tab-navs .report-tab-nav:hover {
  color: "@@color500";
}
[data-tab="report"] #report-tab-navs [data-name="report"],
[data-tab="inbox"] #report-tab-navs [data-name="inbox"],
[data-tab="settings"] #report-tab-navs [data-name="settings"] {
  color: "@@color500";
}
[data-tab="report"] #report-tab-navs [data-name="report"]::before,
[data-tab="inbox"] #report-tab-navs [data-name="inbox"]::before,
[data-tab="settings"] #report-tab-navs [data-name="settings"]::before {
  background-color: "@@color300";
}
#report-item-filter #filter-form .filter-item .filter-item-selected:hover {
  background-color: "@@color50";
}
#report-item-filter #filter-form .filter-item::before {
  background-color: "@@color100";
}
#report-item-filter #filter-form .filter-item .filter-item-icon .filter-item-assignee-image {
  border-color: "@@color500";
}
#report-item-filter #filter-form .filter-item .filter-item-options {
  border-color: "@@color100";
}
#report-item-filter #filter-form .filter-item:hover {
  background-color: "@@color50";
}
#report-item-filter #filter-form .filter-item:hover .filter-item-icon .filter-item-assignee-image-all .filter-item-assignee-image {
  background-color: "@@color50";
}
#report-item-filter #filter-form .filter-item.active .filter-item-selected {
  background-color: "@@color50";
}
#report-item-filter #filter-form .filter-item.active .filter-item-icon .filter-item-assignee-image-all .filter-item-assignee-image {
  background-color: "@@color50";
}
#report-item-filter #filter-form .filter-item.active .filter-item-options .filter-item-option:hover {
  background-color: "@@color50";
}
#report-item-filter #filter-form .filter-item.active .filter-item-options .filter-item-option:hover .filter-item-assignee-image-all .filter-item-assignee-image {
  background-color: "@@color50";
}
#report-item-filter #filter-form .filter-item.active .filter-item-options .filter-item-option.active {
  background-color: "@@color500";
}
#report-item-filter #filter-form .filter-item.active .filter-item-options .filter-item-option.active .filter-item-assignee-image {
  background-color: "@@color500";
}
#report-item-filter #filter-form .filter-item.active .filter-item-options .filter-item-option.active .filter-item-assignee-image-all .filter-item-assignee-image {
  background-color: "@@color500";
}
.form-select {
  border-bottom-color: "@@color100";
}
.form-select .form-select-list {
  border-color: "@@color100";
}
.form-select .form-select-list li:hover {
  background-color: "@@color50";
}
.form-select .form-select-list li.active {
  background-color: "@@color500";
}
.form-select:hover {
  background-color: "@@color50";
}
.form-select.active {
  background-color: "@@color50";
}
.form-checkbox::before {
  border-color: "@@color100";
}
.form-checkbox:hover::before {
  background-color: "@@color50";
}
.form-checkbox.active::before {
  color: "@@color500";
}
.item .item-state .item-state-option {
  border-top-color: "@@color500";
  border-bottom-color: "@@color500";
}
.item .item-content {
  color: "@@color900";
}
.item .item-screenshots {
  border-top-color: "@@color100";
  border-bottom-color: "@@color100";
  border-left-color: "@@color100";
}
.item .item-screenshots-title {
  color: "@@color500";
  border-bottom-color: "@@color100";
}
.item .item-screenshot:hover {
  background-color: "@@color100";
}
.item .item-available-assignees::before {
  border-top-color: "@@color200";
}
.item .item-available-assignees .item-available-assignees-content {
  border-top-color: "@@color200";
  border-bottom-color: "@@color200";
}
.item .item-available-assignees .item-available-assignee:hover {
  background-color: "@@color100";
}
.item .item-available-assignees .item-available-assignee.active {
  background-color: "@@color500";
}
.item .item-assignees .item-assignee .item-assignee-image i {
  background-color: "@@color500";
}
.item .item-assignees .item-assignee-add .item-assignee-add-button::before {
  background-color: "@@color200";
}
.item .item-assignees .item-assignee-add:hover .item-assignee-add-button {
  border-color: "@@color200";
}
.show-assignees.item .item-assignees .item-assignee-add .item-assignee-add-button {
  border-color: "@@color200";
}
.item .comment-item.comment-owner .comment-user-image {
  border-color: "@@color500";
}
.item .comment-item.comment-owner .comment-user-image .user-avatar-initial {
  color: "@@color500";
}
.item .comment-item.comment-owner .comment-user-text {
  border-color: "@@color100";
}
.item .comment-item.comment-owner .comment-user-text::after {
  border-left-color: "@@color100";
}
.item .comment-item.comment-owner .comment-user-text p {
  background-color: "@@color50";
  color: "@@color700";
}
.item .comment-reply-input {
  color: "@@color700";
}
.item .comment-reply-button {
  color: "@@color500";
}
#screenshot-preview #screenshot-preview-close-button {
  color: "@@color500";
}
#screenshot-preview #screenshot-preview-close-button:hover {
  color: "@@color700";
}
#screenshot-preview img {
  border-color: "@@color500";
}
#report-close-button:hover {
  color: "@@color100";
}
.form-group label {
  color: "@@color700";
}
.form-group input[type="text"] {
  color: "@@color500";
  border-bottom-color: "@@color100";
}
.form-group input[type="text"]:focus {
  color: "@@color700";
  border-bottom-color: "@@color500";
}
.form-group input[type="text"]::placeholder {
  color: "@@color100";
}
.form-group input[type="text"]::-webkit-input-placeholder {
  color: "@@color100";
}
.form-group input[type="text"]:-moz-placholder {
  color: "@@color100";
}
.form-group input[type="text"]::-moz-placholder {
  color: "@@color100";
}
.form-group input[type="text"]:-ms-input-placeholder {
  color: "@@color100";
}
.form-group input[type="text"]::-ms-input-placeholder {
  color: "@@color100";
}
.form-group textarea {
  background-color: "@@color50";
}
.form-group textarea:focus {
  color: "@@color900";
  border-bottom-color: "@@color500";
}
.form-submit {
  background-color: "@@color700";
  color: "@@color50";
}
.form-submit:hover {
  background-color: "@@color800";
}
.report-screenshots .report-screenshot {
  border-color: "@@color50";
}
.report-screenshots .report-screenshot:hover {
  border-color: "@@color300";
}
.report-screenshots .report-screenshot .report-screenshot-delete {
  background-color: "@@color50";
  color: "@@color300";
}
.report-screenshots .report-screenshot .report-screenshot-delete:hover {
  background-color: "@@color300";
}
.report-screenshots #report-screenshot-add {
  border-color: "@@color200";
  color: "@@color200";
}
.report-screenshots #report-screenshot-add:hover {
  border-color: "@@color500";
  color: "@@color500";
  background-color: "@@color50";
}
#drop-file-mask {
  border-color: "@@color500";
}
#report-submitting::before {
  background-color: "@@color900";
}
.report-item-back {
  color: "@@color500";
}
.report-item-back:hover {
  background-color: "@@color500";
}
.report-project {
  border-bottom-color: "@@color100";
}
.report-project .project-name::before {
  background-color: "@@color100";
}
#settings-form .notification-settings .form-field:hover .form-checkbox::before {
  background-color: "@@color50";
}