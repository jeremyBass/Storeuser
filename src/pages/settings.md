{# 
{
	"name":"settings",
	"root":"./site/",
	"folder_root":"../site/",
	"title":"Settings",
	"nav_title":"Settings",
	"vars":{
		"showstuff":true
	},
	"child_nav":{
		"#storepartitions_basicsettings":"Basic",
		"#storepartitions_storesettings:"Site",
		"#storepartitions_general":"Advanced Permissions",
		"#storepartitions_su":"Product Approve",
		"#storepartitions_sucategories":"Category Approve"
	}
}
#}
{% markdown %}

# Store Partitions

## basic settings

![Settings Area](site/assests/img/settings-area.png)

{% endmarkdown %}
<div id="anchor-content">
		<div id="page:main-container">
				<div>
						<div id="content">
								<div>
										<form action="http://store.wsu.dev/index.php/admin/system_config/save/section/storepartitions/key/9a8fec4f7d0b47590dbf809d9508307d/" method="post" id="config_edit_form" enctype="multipart/form-data">
												<div>
														<div>
																<div><h2 id="storepartitions_basicsettings-head">Basic Settings</h2></div>
																<fieldset id="storepartitions_basicsettings">
																		<legend></legend>
																		<div></div>
																		<table cellspacing="0">
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<tbody>
																						<tr id="row_storepartitions_basicsettings_active">
																								<td><label for="storepartitions_basicsettings_active2">Enabled</label></td>
																								<td><select id="storepartitions_basicsettings_active2" name="groups[basicsettings][fields][active][value]">
																										 
																										<option value="1" selected="selected">Yes</option>
																										 
																										<option value="0">No</option>
																										 
																								</select>
																										<p> </p></td>
																								<td>[WEBSITE]</td>
																								<td></td>
																						</tr>
																				</tbody>
																		</table>
																</fieldset>
														</div>
														<div>
																<div><h2 id="storepartitions_storesettings-head">Site handling</h2></div>
																<fieldset id="storepartitions_storesettings">
																		<legend></legend>
																		<table cellspacing="0">
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<tbody>
																						<tr id="row_storepartitions_storesettings_setroot">
																								<td><label for="storepartitions_storesettings_setroot">Use a root Site</label></td>
																								<td><select id="storepartitions_storesettings_setroot" name="groups[storesettings][fields][setroot][value]">
																										 
																										<option value="1">Yes</option>
																										 
																										<option value="0" selected="selected">No</option>
																										 
																								</select>
																										<p>If set to "yes", the store set will server as a shell store where all account and cart actions occur.</p></td>
																								<td>[STORE VIEW]</td>
																								<td></td>
																						</tr>
																				</tbody>
																		</table>
																</fieldset>
														</div>
														<div>
																<div><h2 id="storepartitions_general-head">Advanced Permissions</h2></div>
																<fieldset id="storepartitions_general">
																		<legend></legend>
																		<table cellspacing="0">
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<tbody>
																						<tr id="row_storepartitions_general_mapping">
																								<td><label for="storepartitions_general_mapping">Auto map files for NGINX</label></td>
																								<td><select id="storepartitions_general_mapping" name="groups[general][fields][mapping][value]">
																										 
																										<option value="1" selected="selected">Yes</option>
																										 
																										<option value="0">No</option>
																										 
																								</select>
																										<p>If set to "Yes", an entry will be added to the maps/nginx-mapping.conf.</p></td>
																								<td>[STORE VIEW]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_general_showallproducts">
																								<td><label for="storepartitions_general_showallproducts">Display All Products</label></td>
																								<td><select id="storepartitions_general_showallproducts" name="groups[general][fields][showallproducts][value]">
																										 
																										<option value="1">Yes</option>
																										 
																										<option value="0" selected="selected">No</option>
																										 
																								</select>
																										<p>If set to "No", user will see only products from categories assigned to him.</p></td>
																								<td>[STORE VIEW]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_general_showallcustomers">
																								<td><label for="storepartitions_general_showallcustomers">Show All Customers</label></td>
																								<td><select id="storepartitions_general_showallcustomers" name="groups[general][fields][showallcustomers][value]">
																										 
																										<option value="1" selected="selected">Yes</option>
																										 
																										<option value="0">No</option>
																										 
																								</select>
																										<p>If set to "No" user with restricted permissions can view customers from the website of the allowed store only.</p></td>
																								<td>[WEBSITE]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_general_allow_null_category">
																								<td><label for="storepartitions_general_allow_null_category">Show products without categories</label></td>
																								<td><select id="storepartitions_general_allow_null_category" name="groups[general][fields][allow_null_category][value]">
																										 
																										<option value="1">Yes</option>
																										 
																										<option value="0" selected="selected">No</option>
																										 
																								</select>
																										<p>If set to "No" sub-admin will not be able to see products, which don't have any category assigned. Only Super Admin will be able to see such products.</p></td>
																								<td>[STORE VIEW]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_general_allowdelete">
																								<td><label for="storepartitions_general_allowdelete">Allow Deletion (Store-view restriction)</label></td>
																								<td><select id="storepartitions_general_allowdelete" name="groups[general][fields][allowdelete][value]">
																										 
																										<option value="1">Yes</option>
																										 
																										<option value="0" selected="selected">No</option>
																										 
																								</select>
																										<p>If set to "Yes" user with restricted permissions per Store-view can delete products, product images and categories.</p></td>
																								<td>[STORE VIEW]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_general_allowdelete_perwebsite">
																								<td><label for="storepartitions_general_allowdelete_perwebsite">Allow Deletion (Website restriction)</label></td>
																								<td><select id="storepartitions_general_allowdelete_perwebsite" name="groups[general][fields][allowdelete_perwebsite][value]">
																										 
																										<option value="1">Yes</option>
																										 
																										<option value="0" selected="selected">No</option>
																										 
																								</select>
																										<p>If set to "Yes" user with restricted permissions per Website can delete products, product images and categories.</p></td>
																								<td>[STORE VIEW]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_general_show_admin_on_product_grid">
																								<td><label for="storepartitions_general_show_admin_on_product_grid">Show product owner login on Catalog product grid</label></td>
																								<td><select id="storepartitions_general_show_admin_on_product_grid" name="groups[general][fields][show_admin_on_product_grid][value]">
																										 
																										<option value="1">Yes</option>
																										 
																										<option value="0" selected="selected">No</option>
																										 
																								</select></td>
																								<td>[STORE VIEW]</td>
																								<td></td>
																						</tr>
																				</tbody>
																		</table>
																</fieldset>
														</div>
														<div>
																<div><h2 id="storepartitions_su-head" >Products approve</h2></div>
																<fieldset id="storepartitions_su">
																		<legend></legend>
																		<table cellspacing="0">
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<tbody>
																						<tr id="row_storepartitions_su_enable">
																								<td><label for="storepartitions_su_enable">Enable Products Approve</label></td>
																								<td><select id="storepartitions_su_enable" name="groups[su][fields][enable][value]">
																										 
																										<option value="1" selected="selected">Yes</option>
																										 
																										<option value="0">No</option>
																										 
																								</select></td>
																								<td>[WEBSITE]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_su_email">
																								<td><label for="storepartitions_su_email">Use custom email to send notifications</label></td>
																								<td><input id="storepartitions_su_email" name="groups[su][fields][email][value]" value="" type="text">
																										<p>If the field is empty, the notification will sent to the standard admin sales e-mail</p></td>
																								<td>[WEBSITE]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_su_template">
																								<td><label for="storepartitions_su_template">Email template</label></td>
																								<td><select id="storepartitions_su_template" name="groups[su][fields][template][value]">
																										 
																										<option value="storepartitions_su_template" selected="selected">Default Template from Locale</option>
																										 
																								</select></td>
																								<td>[WEBSITE]</td>
																								<td></td>
																						</tr>
																				</tbody>
																		</table>
																</fieldset>
														</div>
														<div>
																<div><h2 id="storepartitions_sucategories-head">New Categories Approve</h2></div>
																<fieldset id="storepartitions_sucategories">
																		<legend></legend>
																		<table cellspacing="0">
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<colgroup>
																				</colgroup>
																				<tbody>
																						<tr id="row_storepartitions_sucategories_enable">
																								<td><label for="storepartitions_sucategories_enable">Enable New Categories Approve</label></td>
																								<td><select id="storepartitions_sucategories_enable" name="groups[sucategories][fields][enable][value]">
																										 
																										<option value="1">Yes</option>
																										 
																										<option value="0" selected="selected">No</option>
																										 
																								</select></td>
																								<td>[GLOBAL]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_sucategories_require_cat">
																								<td><label for="storepartitions_sucategories_require_cat">Require Categories on Product save</label></td>
																								<td><select id="storepartitions_sucategories_require_cat" name="groups[sucategories][fields][require_cat][value]">
																										 
																										<option value="1" selected="selected">Yes</option>
																										 
																										<option value="0">No</option>
																										 
																								</select></td>
																								<td>[GLOBAL]</td>
																								<td></td>
																						</tr>
																						<tr id="row_storepartitions_sucategories_email">
																								<td><label for="storepartitions_sucategories_email">Use custom email to send notifications</label></td>
																								<td><input id="storepartitions_sucategories_email" name="groups[sucategories][fields][email][value]" value="" type="text">
																										<p>If the field is empty, the notification will sent to the standard admin sales e-mail</p></td>
																								<td>[GLOBAL]</td>
																								<td></td>
																						</tr>
																				</tbody>
																		</table>
																</fieldset>
														</div>
												</div>
										</form>
								</div>
						</div>
				</div>
		</div>
</div>
<div>
<div>
<div>
<br>

