<template>
	<div>
		<div class="mt-4">
			<div class="container">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div
					class="
						_1adminOverveiw_table_recent
						_box_shadow
						_border_radious
						_mar_b30
						_p20
						col-md-8
						mx-auto
					"
				>
					<Form :model="formItem" :label-width="80">
						<FormItem label="Name">
							<Input type="text" v-model="formItem.name"></Input>
						</FormItem>
						<FormItem label="Email">
							<Input
								type="email"
								v-model="formItem.email"
							></Input>
						</FormItem>
						<FormItem label="Image">
							<Upload
								ref="uploads"
								:on-success="handleSuccess"
								:format="['jpg', 'jpeg', 'png']"
								:max-size="2048"
								:on-format-error="handleFormatError"
								:on-exceeded-size="handleMaxSize"
								:headers="{
									'x-csrf-token': token,
									'X-Requested-With': 'XMLHttpRequest',
								}"
								action="/app/upload"
							>
								<Button icon="ios-cloud-upload-outline"
									>Choose file</Button
								>
							</Upload>
						</FormItem>
						<div class="demo-upload-list" v-if="formItem.image">
							<img :src="`${formItem.image}`" />
							<div class="demo-upload-list-cover">
								<Icon
									type="ios-trash-outline"
									@click="deleteImage"
								></Icon>
							</div>
						</div>
						<FormItem label="Gender">
							<RadioGroup v-model="formItem.gender">
								<Radio label="male">Male</Radio>
								<Radio label="female">Female</Radio>
							</RadioGroup>
						</FormItem>
						<FormItem label="Skills">
							<CheckboxGroup v-model="formItem.skills">
								<Checkbox label="Laravel"></Checkbox>
								<Checkbox label="Codeigniter"></Checkbox>
								<Checkbox label="Vue Js"></Checkbox>
								<Checkbox label="Ajax"></Checkbox>
								<Checkbox label="MySql"></Checkbox>
								<Checkbox label="API"></Checkbox>
							</CheckboxGroup>
						</FormItem>
						<FormItem>
							<Button type="primary" @click="addData"
								>Submit</Button
							>
						</FormItem>
					</Form>
				</div>
				<!-- <Page :total="100" /> -->
			</div>

			<div class="container-fluid">
				<div
					class="
						_1adminOverveiw_table_recent
						_box_shadow
						_border_radious
						_mar_b30
						_p20
						col-md-12
						mx-auto
					"
				>
					<div class="_overflow _table_div">
						<table class="_table">
							<!-- TABLE TITLE -->
							<tr>
								<th>Serial No.</th>
								<th>Name</th>
								<th>Email</th>
								<th>Image</th>
								<th>Gender</th>
								<th>Skills</th>
								<th>Action</th>
							</tr>
							<!-- TABLE TITLE -->

							<!-- ITEMS -->
							<tr
								v-for="(dataS, i) in data"
								:key="i"
								v-if="data.length"
							>
								<td>{{ i + 1 }}</td>
								<td class="_table_name">
									{{ dataS.name }}
								</td>
								<td>{{ dataS.email }}</td>
								<td style="width: 40px; height: 30px">
									<img :src="`${dataS.image}`" />
								</td>
								<td>
									{{
										dataS.gender == "male"
											? "Male"
											: "Female"
									}}
								</td>
								<td>
									{{ dataS.skills }}
								</td>
								<td>
									<Button
										type="info"
										size="small"
										@click="showEditData(dataS, i)"
										>Edit</Button
									>
									<Button
										type="error"
										size="small"
										@click="showDeletingModal(dataS, i)"
										:loading="dataS.isDelete"
										>Delete</Button
									>
								</td>
							</tr>
							<!-- ITEMS -->
						</table>

						<!-- Deleting Modal -->

						<Modal v-model="showDeleteModal" width="360">
							<p
								slot="header"
								style="color: #f60; text-align: center"
							>
								<Icon type="ios-information-circle"></Icon>
								<span>Delete confirmation</span>
							</p>
							<div style="text-align: center">
								<p>Are You sure to delete this Data?</p>
							</div>
							<div slot="footer">
								<Button
									type="error"
									size="large"
									long
									:loading="isDeleting"
									:disabled="isDeleting"
									@click="deleteTag"
									>Delete</Button
								>
							</div>
						</Modal>
					</div>
				</div>
			</div>
			<!-- <Page :total="100" /> -->

			<!-- Edit modaal -->
			<Modal
				v-model="editModal"
				title="Edit Data"
				:mask-closable="false"
				:closable="false"
			>
				<div class="space">
					<p class="spc_p">Name</p>
					<Input
						type="text"
						v-model="editData.name"
						placeholder="Enter Name..."
					></Input>
				</div>

				<div class="space">
					<p class="spc_p">Email</p>
					<Input
						type="email"
						v-model="editData.email"
						placeholder="Enter Email Address..."
					></Input>
				</div>

				<div class="space">
					<p class="spc_p">Image</p>
					<Upload
						v-show="isImageNew"
						ref="uploadsEditImage"
						:on-success="handleSuccess"
						:format="['jpg', 'jpeg', 'png']"
						:max-size="2048"
						:on-format-error="handleFormatError"
						:on-exceeded-size="handleMaxSize"
						:headers="{
							'x-csrf-token': token,
							'X-Requested-With': 'XMLHttpRequest',
						}"
						action="/app/upload"
					>
						<Button icon="ios-cloud-upload-outline"
							>Choose file</Button
						>
					</Upload>
					<div class="demo-upload-list" v-if="editData.image">
						<img :src="`${editData.image}`" />
						<div class="demo-upload-list-cover">
							<Icon
								type="ios-trash-outline"
								@click="deleteImage(false)"
							></Icon>
						</div>
					</div>
				</div>

				<div class="space">
					<p class="spc_p">Gender</p>
					<RadioGroup
						v-model="editData.gender"
						placeholder="Select Gender..."
					>
						<Radio label="male">Male</Radio>
						<Radio label="female">Female</Radio>
					</RadioGroup>
				</div>

				<div class="space">
					<p class="spc_p">Skills</p>
					<!-- <CheckboxGroup
						type="checkbox"
						v-model="editData.skills"
						placeholder="Select Skills..."
					>
						<Checkbox label="Laravel" v-if="tempSkills[0]"></Checkbox>
						<Checkbox label="Codeigniter"></Checkbox>
						<Checkbox label="Vue Js"></Checkbox>
						<Checkbox label="Ajax"></Checkbox>
						<Checkbox label="MySql"></Checkbox>
						<Checkbox label="API"></Checkbox>
					</CheckboxGroup> -->

					<div v-for="skillS in skill" class="checkbox_modal">
						<label>
							<input
								class="uk-checkbox"
								type="checkbox"
								:value="skillS.name"
								v-model="hasSkill"
								@change="onChangeProcessed($event, skillS.name)"
							/>
							{{ skillS.name }}
						</label>
					</div>
				</div>

				<!-- <div class="image_thumb" v-if="data.iconImage">
                        <img :src ="`/admin/category/${data.iconImage}`">
                    </div> -->

				<div slot="footer">
					<Button type="default" @click="closeEditModal"
						>Close</Button
					>
					<Button
						type="primary"
						@click="editDataFrom"
						:disabled="isAdding"
						:loading="isAdding"
						>{{ isAdding ? "Editing..." : "Update Data" }}</Button
					>
				</div>
			</Modal>
		</div>
	</div>
</template>

<style>
.checkbox_modal {
	display: inline-block;
	margin-left: 8px;
}
.spc_p {
	margin-bottom: 5px;
}
.space {
	margin: 15px 0;
}
.demo-upload-list {
	display: block;
	width: 150px;
	height: 105px;
	text-align: center;
	margin-left: 82px;
	margin-bottom: 15px;
	line-height: 100px;
	border: 1px solid transparent;
	border-radius: 4px;
	overflow: hidden;
	background: #fff;
	position: relative;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
	margin-right: 4px;
}
.demo-upload-list img {
	width: 150px;
	height: 100px;
}
.demo-upload-list-cover {
	width: 100%;
	height: 100%;
	display: none;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	background: rgba(0, 0, 0, 0.6);
}
.demo-upload-list:hover .demo-upload-list-cover {
	display: block;
}
.demo-upload-list-cover i {
	color: #fff;
	font-size: 20px;
	cursor: pointer;
	margin: 0 2px;
}
</style>

<script>
export default {
	props: ["ret"],
	data() {
		return {
			formItem: {
				name: "",
				email: "",
				image: "",
				skills: [],
				gender: "",
			},
			skill: [
				{ name: "Laravel" },
				{ name: "Codeigniter" },
				{ name: "Vue Js" },
				{ name: "Ajax" },
				{ name: "MySql" },
				{ name: "API" },
			],
			data: [],
			editData: {
				tagName: "",
			},
			editModal: false,
			editData: {
				name: "",
				email: "",
				image: "",
				skills: [],
				gender: "",
			},
			index: -1,
			isAdding: false,
			showDeleteModal: false,
			isDeleting: false,
			deleteItem: {},
			deletingIndex: -1,
			token: "",
			tempSkills: [],
			isImageNew: false,
			isEditingItem: false,
		};
	},
	computed: {
		hasSkill: {
			get() {
				let tempSkills = this.tempSkills;
				let skill = this.skill;
				let ret = [];
				let tl = 0;
				for (let i = 0; i < tempSkills.length; i++) {
					for (let j = 0; j < skill.length; j++) {
						if (skill[j].name == tempSkills[i]) {
							ret[tl] = skill[j].name;
							// tempSkills[tl] = skill[j].name;
							tl = tl + 1;
						}
					}
				}
				this.tempSkills = ret;
				// console.log(ret);
				return ret;
			},
			set(newVal) {
				// console.log(newVal[newVal.length - 1]);
				// console.log(nv);
				// this.editData.push({skills : newVal[newVal.length-1]});

				let temp1 = this.editData.skills.length;
				this.editData.skills[temp1] = newVal[newVal.length - 1];
				newVal.length = newVal.length + 1;

				this.editData.skills = [...new Set(this.editData.skills)];

				// console.log(this.editData.skills.length);
				// this.editData.skills.splice(this.editData.skills.length, 1);
				// this.$delete(this.editData.skills, this.editData.skills.length-1);
				console.log(this.editData.skills);
				// console.log(Array.isArray(this.editData.skills));
				// let tempSkills = this.tempSkills;
				// let ts = tempSkills.length;

				// this.editData.skills= newVal;
				// console.log(this.tempSkills);
				// console.log(ts);
				//this function will run whenever the input changes
				// this.value = newVal / 2;
			},
		},
	},
	methods: {
		async addData() {
			if (this.formItem.name.trim() == "") {
				return this.e("Name is required");
			}
			if (this.formItem.email.trim() == "") {
				return this.e("Email is required");
			}
			if (this.formItem.image.trim() == "") {
				return this.e("Image is required");
			}
			if (this.formItem.gender.trim() == "") {
				return this.e("Gender is required");
			}
			if (this.formItem.skills.checked == false) {
				return this.e("Skill is required");
			}
			this.formItem.image = `${this.formItem.image}`;
			console.log(this.formItem.skills);
			const res = await this.callApi(
				"post",
				"app/create_data",
				this.formItem
			);
			// console.log(res)
			if (res.status == 201) {
				// console.log(res)
				this.data.unshift(res.data);
				this.s("Data has been added successfuly");
				this.formItem.name = "";
				this.formItem.email = "";
				this.formItem.image = "";
				this.formItem.gender = "";
				this.formItem.skills = [];
				this.$refs.uploads.clearFiles();
			} else {
				if (res.status === 422) {
					if (res.data.errors.name) {
						this.e(res.data.errors.name[0]);
					}
					if (res.data.errors.email) {
						this.e(res.data.errors.email[0]);
					}
					if (res.data.errors.image) {
						this.e(res.data.errors.image[0]);
					}
					if (res.data.errors.gender) {
						this.e(res.data.errors.gender[0]);
					}
					if (res.data.errors.skills) {
						this.e(res.data.errors.skills[0]);
					}
				} else {
					this.swr();
				}
			}
		},

		removeDuplicates() {
			this.editData.skills = [...new Set(this.editData.skills)];
		},
		onChangeProcessed(e, d) {
			if (e.target.checked == false) {
				console.log(d);
				// console.log(e.target.checked);

				// this.markNotReady(d);

				this.editData.skills.splice(this.editData.skills.indexOf(d), 1);
				console.log(this.editData.skills);
				/*       console.log(e.target.value);
                    this.markNotReady(d) */
			}
		},

		async editDataFrom() {
			console.log(this.editData);
			if (this.editData.name.trim() == "") {
				return this.e("Name is required");
			}
			if (this.editData.email.trim() == "") {
				return this.e("Email is required");
			}
			if (this.editData.image.trim() == "") {
				return this.e("Image is required");
			}
			if (this.editData.gender.trim() == "") {
				return this.e("Gender is required");
			}
			if (this.editData.skills.checked == false) {
				return this.e("Skill is required");
			}
			console.log(this.editData);
			const res = await this.callApi(
				"post",
				"app/edit_data",
				this.editData
			);
			// console.log(res)
			if (res.status === 200) {
				this.data[this.index].name = this.editData.name;
				// console.log(res)
				// this.tags.unshift(res.data);
				this.s("Data has been edited successfuly");
				this.editModal = false;
				this.editData.skills = JSON.stringify(this.editData.skills);
				this.tempSkills = JSON.stringify(this.tempSkills);
				console.log(this.tempSkills);
				this.tempSkills = [];
				this.editData = "";
			} else {
				if (res.status === 422) {
					if (res.data.errors.name) {
						this.e(res.data.errors.name[0]);
					}
					if (res.data.errors.email) {
						this.e(res.data.errors.email[0]);
					}
					if (res.data.errors.image) {
						this.e(res.data.errors.image[0]);
					}
					if (res.data.errors.gender) {
						this.e(res.data.errors.gender[0]);
					}
					if (res.data.errors.skills) {
						this.e(res.data.errors.skills[0]);
					}
				} else {
					this.swr();
				}
			}
		},
		getFilteredData: function () {
			// some computing needed
			// refresh vue
			Vue.set(me, "skills", []);
		},

		filterMedia: function () {
			this.getFilteredData();
		},
		showEditData(dataS, index) {
			// let obj = {
			// 	id: dataS.id,
			// 	name: dataS.name,
			// 	email: dataS.email,
			// 	image: dataS.image,
			// 	gender: dataS.gender,
			// };

			this.editData = dataS;
			this.tempSkills = JSON.parse(this.editData.skills);
			this.editData.skills = JSON.parse(this.editData.skills);
			// console.log(JSON.parse(this.editData.skills));
			this.editModal = true;
			this.index = index;
			this.isEditingItem = true;
		},
		async deleteTag() {
			this.isDeleting = true;

			const res = await this.callApi(
				"post",
				"app/delete_data",
				this.deleteItem
			);

			if (res.status === 200) {
				this.data.splice(this.deletingIndex, 1);
				this.s("Data has been deleted successfully");
			} else {
				this.swr();
			}
			this.isDeleting = false;
			this.showDeleteModal = false;
		},
        showDeletingModal(dataS, i){
            this.deleteItem = dataS;
            this.deletingIndex = i; 
            this.showDeleteModal = true
        },
		handleSuccess(res, file) {
			res = `/uploads/${res}`;
			if (this.isEditingItem) {
				// res = `/uploads/${res}`;
				return (this.editData.image = res);
			}
			this.formItem.image = res;
		},
		handleError(res, file) {
			this.$Notice.warning({
				title: "The file format is incorrect",
				desc: `${
					file.errors.file.length
						? file.errors.file[0]
						: "Something went wrong"
				}`,
			});
		},
		handleFormatError(file) {
			this.$Notice.warning({
				title: "The file format is incorrect",
				desc:
					"File format of " +
					file.name +
					" is incorrect, please select jpg or png or jpwg.",
			});
		},
		handleMaxSize(file) {
			this.$Notice.warning({
				title: "Exceeding file size limit",
				desc: "File  " + file.name + " is too large, no more than 2M.",
			});
		},
		async deleteImage(isAdd = true) {
			let image;
			console.log("hi");
			console.log(this.formItem.image);
			if (!isAdd) {
				this.isImageNew = true;
				image = this.editData.image;
				this.editData.image = "";
				this.$refs.uploadsEditImage.clearFiles();

				// console.log(isAdd);
			} else {
				image = this.formItem.image;
				this.formItem.image = "";
				this.$refs.uploads.clearFiles();
			}
			// console.log(this.data.iconImage)

			const res = await this.callApi("post", "app/delete_image", {
				fileName: image,
			});

			if (res.status != 200) {
				this.formItem.image = image;
				this.swr();
			}
		},
    
		closeEditModal() {
			this.isEditingItem = false;
			this.editModal = false;
			this.editData.skills = JSON.stringify(this.editData.skills);
			this.tempSkills = JSON.stringify(this.tempSkills);
			console.log(this.tempSkills);
			this.tempSkills = [];
			this.editData = "";
			console.log(this.editData);
		},
	},

	async created() {
		this.token = window.Laravel.csrfToken;
		const res = await this.callApi("get", "app/get_data");
		if (res.status === 200) {
			this.data = res.data;

			// this.tempSkills = res.data;

			// this.tempSkills = JSON.parse(JSON.stringify(res.data));
			// const final_data = Array.from(res.data);
			// console.log(this.tempSkills.skills)

			// this.tempSkills = JSON.parse(res.data.skills[]);
		} else {
			this.swr();
		}
	},
};
</script>
