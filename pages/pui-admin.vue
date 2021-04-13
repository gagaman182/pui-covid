<template>
  <v-row>
    <v-col>
      <div>
        <v-alert color="#949cdf" dark>
          <p class="headline">
            แสดงข้อมูลทะเบียนรับแจ้งเพื่อรายงานตัวเข้ารับการตรวจหาเชื้อในกลุ่มเสี่ยงสูง(PUI
            / COVID-19) โรงพยาบาลหาดใหญ่
          </p>
        </v-alert>
      </div>
      <v-card-actions>
        <v-spacer />
        <v-btn color="#51c4d3" dark x-large
          ><export-excel :data="desserts_thai"> Excel </export-excel>
        </v-btn>
      </v-card-actions>

      <v-data-table
        height="600px"
        :headers="headers"
        :items="desserts"
        :items-per-page="15"
        class="elevation-1"
        :search="search"
        ><template v-slot:top>
          <v-text-field
            v-model="search"
            label="ค้นหา"
            class="mx-4"
          ></v-text-field> </template
      ></v-data-table>
    </v-col>
  </v-row>
</template>
<script>
import axios from 'axios'
export default {
  name: 'pui-admin',
  data() {
    return {
      search: '',
      headers: [
        {
          text: 'เวลาที่บันทึก',
          sortable: true,
          value: 'date_add',
          width: '400px',
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
        })
    },
    async fecth_pui_thai() {
      await axios
        .get(`${this.$axios.defaults.baseURL}pui_thai.php`)
        .then((response) => {
          this.desserts_thai = response.data
        })
    },
  },
}
</script>
<style>
html {
  font-family: 'Prompt';
}
</style>
