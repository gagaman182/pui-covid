<template>
  <v-row>
    <v-col cols="12" md="12">
      <div align="center">
        <v-alert color="#8fd9a8" dark>
          <p class="headline">
            แสดงข้อมูลทะเบียนรับแจ้งเพื่อรายงานตัวเข้ารับการตรวจหาเชื้อในกลุ่มเสี่ยงสูง(PUI
            / COVID-19) โรงพยาบาลหาดใหญ่
          </p>
        </v-alert>
        <v-card-actions>
          <v-spacer />
          <v-btn color="#51c4d3" dark x-large
            ><export-excel :data="desserts_thai">
              <v-icon medium>mdi-file-excel </v-icon>
            </export-excel>
          </v-btn>
        </v-card-actions>
      </div></v-col
    >
    <v-col cols="12" md="4">
      <v-menu
        v-model="fromDateMenu"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="auto"
      >
        <template v-slot:activator="{ on }">
          <v-text-field
            prepend-inner-icon="mdi-calendar-range "
            label="ระบุวันที่..."
            readonly
            :value="fromDateDisp"
            v-on="on"
            v-model="datecontactstring"
            outlined
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="datecontact"
          no-title
          @input="fromDateMenu = false"
          locale="th-TH"
        ></v-date-picker> </v-menu
    ></v-col>
    <v-col cols="12" md="1"
      ><v-btn color="#ff75a0" dark x-large @click="searchtable">
        <v-icon medium>mdi-table-search </v-icon>
      </v-btn></v-col
    >
    <v-col cols="12" md="1"
      ><v-btn color="#4a47a3" dark x-large @click="reload">
        <v-icon medium>mdi-reload </v-icon>
      </v-btn></v-col
    >
    <v-col cols="12" md="6" align="end"
      ><p class="display-1 red--text">
        ข้อมูลผู้สัมผัส {{ desserts.length }} ราย
      </p>
    </v-col>
    <v-col cols="12" :md="coltable">
      <v-app-bar color="#4b778d" dense dark>
        <v-toolbar-title
          ><v-icon medium>mdi-table-account </v-icon
          >&nbsp;ตารางข้อมูล</v-toolbar-title
        >
      </v-app-bar>
      <v-data-table
        height="850px"
        :headers="headers"
        :items="desserts"
        :items-per-page="20"
        class="elevation-1"
        :search="search"
        @click:row="handleClick"
        ><template v-slot:top>
          <v-text-field
            v-model="search"
            label="ค้นหา"
            class="mx-4"
          ></v-text-field> </template
      ></v-data-table>
    </v-col>

    <v-col v-if="showdetail" cols="12" :md="coldetail" style="overflow: auto">
      <v-card style="height: 1040px">
        <v-row>
          <v-col cols="12" md="12">
            <v-app-bar color="#4b778d" dense dark>
              <v-toolbar-title
                ><v-icon medium>mdi-shield-account </v-icon
                >&nbsp;รายละเอียดบุคคล</v-toolbar-title
              >

              <v-spacer></v-spacer>
              <v-btn
                :loading="loading"
                x-large
                class="ma-1"
                color="#be0000"
                @click="close"
                align="end"
              >
                <v-icon medium>mdi-close-outline </v-icon>
              </v-btn>
            </v-app-bar>
          </v-col>
        </v-row>

        <v-card-text>
          <v-row>
            <v-col cols="12" md="6"
              ><v-select
                :items="state"
                label="สถานะการติดตาม"
                v-model="state_update"
                solo
              ></v-select>
            </v-col>
            <v-col cols="12" md="6"
              ><v-btn
                :loading="loading"
                large
                class="ma-1"
                color="#5aa897"
                @click="updatepui"
                align="end"
                dark
              >
                <v-icon medium>mdi-content-save </v-icon>
              </v-btn>
            </v-col>
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >ชื่อ-นามสกุล</v-card-subtitle
              >
              <v-card-title class="headline headcolor">{{
                pui_detail[0].fullname
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >หมายเลขบัตรประจำตัวประชาชน</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].idcard
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >วันเกิด</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].birth
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="2"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >อายุ</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].age
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >เบอร์โทรศัพท์</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].tel
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >บ้านเลขที่</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].address
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >ถนน</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].road
              }}</v-card-title></v-col
            >

            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >ซอย</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].soi
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >หมู่</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].moo
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >ตำบล</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].subdistrict
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >อำเภอ</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].road
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="3"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >จังหวัด</v-card-subtitle
              >
              <v-card-title class="headline">{{
                pui_detail[0].province
              }}</v-card-title></v-col
            >

            <v-col cols="12" md="12"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >มาจากพื้นที่เสี่ยง/พื้นที่สีแดง</v-card-subtitle
              >
              <v-card-title class="subheadline">{{
                pui_detail[0].redaddress_other ,
              }}</v-card-title></v-col
            >
            <v-col cols="12" md="12"
              ><v-card-subtitle class="text-decoration-underline blue--text"
                >สัมมผัสใกล้ชิดกับผู้ป่วยที่ยืนยันเป็น Covid19</v-card-subtitle
              >
              <v-card-title class="subheadline">{{
                pui_detail[0].contact_other ,
              }}</v-card-title></v-col
            >
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>

    <v-dialog v-model="dialog" hide-overlay persistent width="300">
      <v-card color="#8fd9a8" dark>
        <v-card-text>
          ประมวลผล
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
// ทำ date format dd/mm/yyyy datepicker
function gettanggal(str) {
  if (str != null) {
    return (
      str.substring(8, 10) +
      '/' +
      str.substring(5, 7) +
      '/' +
      str.substring(0, 4)
    )
  }
  return ''
}
import axios from 'axios'
export default {
  name: 'pui-admin',
  data() {
    return {
      dialog: false,
      search: '',
      headers: [
        {
          text: 'ลำดับ',
          sortable: true,
          value: 'id',
          width: '100px',
        },
        {
          text: 'เวลาที่บันทึก',
          sortable: true,
          value: 'date_add',
          width: '250px',
        },
        { text: 'คำนำหน้า', sortable: false, value: 'prename', width: '150px' },
        { text: 'ชื่อ', sortable: false, value: 'name', width: '200px' },
        { text: 'นามสกุล', sortable: false, value: 'lastname', width: '200px' },
        {
          text: 'หมายเลขบัตรประจำตัวประชาชน',
          sortable: false,
          value: 'idcard',
          width: '300px',
        },
        { text: 'วันเกิด', sortable: false, value: 'birth', width: '100px' },
        { text: 'อายุ', sortable: false, value: 'age', width: '100px' },
        {
          text: 'เบอร์โทรศัพท์',
          sortable: false,
          value: 'tel',
          width: '200px',
        },
        {
          text: 'บ้านเลขที่',
          sortable: false,
          value: 'address',
          width: '300px',
        },
        { text: 'ถนน', sortable: false, value: 'road', width: '300px' },
        { text: 'ซอย', sortable: false, value: 'soi', width: '300px' },
        { text: 'หมู่', sortable: false, value: 'moo', width: '100px' },
        { text: 'ตำบล', sortable: false, value: 'subdistrict', width: '300px' },
        { text: 'อำเภอ', sortable: false, value: 'district', width: '300px' },
        { text: 'จังหวัด', sortable: false, value: 'province', width: '300px' },

        {
          text: 'พื้นที่เสี่ยง',
          sortable: false,
          value: 'redaddress',
          width: '150px',
        },
        {
          text: 'พื้นที่เสี่ยงระบุ',
          sortable: false,
          value: 'redaddress_other',
          width: '500px',
        },
        {
          text: 'สัมผัสใกล้ชิด',
          sortable: false,
          value: 'contact',
          width: '150px',
        },
        {
          text: 'สัมผัสใกล้ชิดระบุ',
          sortable: false,
          value: 'contact_other',
          width: '500px',
        },
      ],
      desserts: [],
      puidata: '',
      desserts_thai: '',
      showdetail: false,
      coltable: '12',

      coldetail: '12',
      pui_detail: '',
      datecontactstring: '',
      datecontact: '',
      puicount: '',
      state: ['NON PUI', 'LOW RISK', 'SQ', 'SWAB'],
      state_update: '',
    }
  },
  mounted() {
    this.fecth_pui()
    this.fecth_pui_thai()
  },
  methods: {
    async fecth_pui() {
      await axios
        .get(`${this.$axios.defaults.baseURL}pui.php`)
        .then((response) => {
          this.desserts = response.data
          this.puicount = this.desserts.length
          this.dialog = true
        })
    },
    async fecth_pui_thai() {
      await axios
        .get(`${this.$axios.defaults.baseURL}pui_thai.php`)
        .then((response) => {
          this.desserts_thai = response.data
        })
    },
    //click แถว
    handleClick(value) {
      // let cid = value.idcard.substring(1, 14)
      let cid = value.idcard

      axios
        .get(`${this.$axios.defaults.baseURL}pui_detail.php`, {
          params: {
            idcard: cid,
          },
        })
        .then((response) => {
          this.pui_detail = response.data
          // this.generic = generic_edit.map((item) => item.generic)
          this.showdetail = true
          this.coltable = '4'
          this.coldetail = '8'
          this.dialog = true
        })
    },
    close() {
      this.showdetail = false
      this.coltable = '12'
      this.coldetail = '12'
      // this.dialog = true
    },
    searchtable() {
      if (!this.datecontact) {
        this.$swal({
          title: 'ไม่สามารถค้นหาข้อมูลได้',
          text: 'ยังไม่ได้ระบุวันที่',
          icon: 'error',
          confirmButtonText: 'ตกลง',
        })
      } else {
        axios
          .get(`${this.$axios.defaults.baseURL}pui_search.php`, {
            params: {
              datesearch: this.datecontact,
            },
          })
          .then((response) => {
            this.desserts = response.data
            this.datecontact = null
            this.datecontactstring = null
            this.dialog = true
          })

        axios
          .get(`${this.$axios.defaults.baseURL}pui_search_thai.php`, {
            params: {
              datesearch: this.datecontact,
            },
          })
          .then((response) => {
            this.desserts_thai = response.data
          })
      }
    },
    reload() {
      this.fecth_pui()
    },
    updatepui() {
      axios
        .post(`${this.$axios.defaults.baseURL}update_pui.php`, {
          state_update: this.state_update,
          idcard: this.pui_detail[0].idcard,
        })
        .then((response) => {
          this.message = response.data
          if (this.message[0].message === 'เพิ่มข้อมูลสำเร็จ') {
            this.$swal({
              title: 'เพิ่มข้อมูลสำเร็จ',
              text: 'สถานะการติดตามถูกเพิ่มแล้ว',
              icon: 'success',
              confirmButtonText: 'ตกลง',
            })
            this.fecth_pui()
          } else {
            this.$swal({
              title: 'ไม่สามารถเพิ่มข้อมูลได้',
              text: this.message[0].message,
              icon: 'error',
              confirmButtonText: 'ตกลง',
            })
          }
        })
    },
  },
  watch: {
    datecontact: function (val, oldVal) {
      this.datecontactstring = gettanggal(val)
    },
    dialog(val) {
      if (!val) return

      setTimeout(() => (this.dialog = false), 300)
    },
  },
}
</script>
<style>
html {
  font-family: 'Prompt';
}
.headcolor {
  color: '#ffd384';
}
</style>
