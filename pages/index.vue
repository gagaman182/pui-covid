<template>
  <v-row justify="center" align="center">
    <v-col cols="12">
      <v-card>
        <v-col cols="12" md="12">
          <vuetify-logo />
        </v-col>
        <div align="center">
          <v-alert color="#51c4d3" dark>
            <p class="headline">
              แบบคัดกรองผู้ป่วย PUI / COVID-19 โรงพยาบาลหาดใหญ่
            </p>
            <br />
            <p class="headline">
              ทะเบียนรับแจ้งเพื่อรายงานตัวเข้ารับการตรวจหาเชื้อในกลุ่มเสี่ยงสูงสำหรับประชาชนอำเภอหาดใหญ่
              จังหวัดสงขลา
            </p>
          </v-alert>
        </div>
        <v-alert border="left" color="#eb5e0b" dark>
          <h3>
            <v-icon medium>mdi-account-voice </v-icon>
            คำแนะนำ !!! ให้กักตัวอยู่บ้านโดยไม่ต้องเดินทางมาโรงพยาบาล
            รอเจ้าหน้าที่ติดต่อกลับเพื่อนัดวันเวลาตรวจ
          </h3>
        </v-alert>
        <v-card-text>
          <v-form ref="form" class="mx-2" lazy-validation>
            <v-row>
              <v-col cols="12" md="12" class="title">
                <p>คำนำหน้า</p>
                <v-select
                  v-model="prename"
                  :items="items"
                  label="เลือก..."
                  solo
                  :rules="prenameRules"
                ></v-select
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>ชื่อ</p>
                <v-text-field
                  v-model="name"
                  solo
                  :rules="nameRules"
                  required
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>นามสกุล</p>
                <v-text-field
                  v-model="lastname"
                  solo
                  :rules="lastnameRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>หมายเลขบัตรประจำตัวประชาชน</p>
                <v-text-field
                  v-model="idcard"
                  :counter="13"
                  :rules="idcardRules"
                  solo
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="12" class="title">
                <p>วันเกิด (วัน/เดือน/ปี)</p>
                <!-- ลง v-facade ทำ format เป็น วันเกิด -->
                <v-text-field
                  v-model="birth"
                  solo
                  v-facade="'##/##/####'"
                  label="##/##/####"
                  :rules="birthRules"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="12" class="title">
                <p>อายุ</p>
                <v-text-field
                  v-model="age"
                  type="number"
                  solo
                  :rules="ageRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>เบอร์โทรศัพท์</p>
                <v-text-field
                  v-model="tel"
                  solo
                  :rules="telRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>บ้านเลขที่ (ที่อยู่ปัจจุบัน / ขณะเริ่มป่วย)</p>
                <v-text-field
                  v-model="address"
                  solo
                  :rules="addressRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>ถนน</p>
                <v-text-field
                  v-model="road"
                  solo
                  :rules="roadRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>ซอย</p>
                <v-text-field
                  v-model="soi"
                  solo
                  :rules="soiRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>หมู่</p>
                <v-text-field
                  v-model="moo"
                  solo
                  :rules="mooRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>ตำบล</p>
                <v-text-field
                  v-model="subdistrict"
                  solo
                  :rules="subdistrictRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>อำเภอ</p>
                <v-text-field
                  v-model="district"
                  solo
                  :rules="districtRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="12" class="title">
                <p>จังหวัด</p>
                <v-text-field
                  v-model="province"
                  solo
                  :rules="provinceRules"
                ></v-text-field
              ></v-col>
              <v-col cols="12" md="4" class="title">
                <div class="text-decoration-underline">
                  <p>มีความเสี่ยงอย่างไร</p>
                </div>
                <v-checkbox
                  v-model="redaddress"
                  label="มาจากพื้นที่เสี่ยง/พื้นที่สีแดง"
                  color="red"
                  value="Y"
                  :rules="redaddressRules"
                  @change="checkred()"
                ></v-checkbox
              ></v-col>
              <v-col cols="12" md="8" class="title">
                <p>คือ</p>
                <v-textarea
                  solo
                  name="input-7-4"
                  label="ระบุ..."
                  v-model="redaddress_other"
                  :rules="redaddress_otherRules"
                  :disabled="redDisable"
                ></v-textarea>
              </v-col>
              <v-col cols="12">
                <v-divider></v-divider>
              </v-col>

              <v-col cols="12" md="4" class="title">
                <v-checkbox
                  v-model="contact"
                  label="สัมผัสใกล้ชิดกับผู้ป่วยที่ยืนยันเป็น Covid19 (ให้ระบุชื่อผู้ป่วยที่ยืนยันผล เหตุการณ์ที่ไหน)"
                  color="red"
                  value="Y"
                  :rules="contactRules"
                  @change="checkcontact()"
                ></v-checkbox
              ></v-col>
              <v-col cols="12" md="8" class="title">
                <p>ระบุ</p>
                <v-textarea
                  solo
                  name="input-7-4"
                  label=" เช่น สถานบันเทิงชื่ออะไร วัน เวลา ที่ชัดเจน"
                  v-model="contact_other"
                  :disabled="contactDisable"
                  :rules="contact_otherRules"
                ></v-textarea>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="#51c4d3" @click="submitForm()" dark x-large>
            บันทึก
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import VuetifyLogo from '~/components/VuetifyLogo.vue'
import axios from 'axios'
export default {
  name: 'index',
  components: {
    VuetifyLogo,
  },
  data: () => ({
    prename: '',
    name: '',
    lastname: '',
    idcard: '',
    birth: '',
    age: '',
    tel: '',
    address: '',
    road: '',
    soi: '',
    moo: '',
    subdistrict: '',
    district: '',
    province: '',
    redaddress: '',
    redaddress_other: '',
    contact: '',
    contact_other: '',

    redDisable: true,
    contactDisable: true,
    items: ['นาย', 'นาง', 'นางสาว'],

    prenameRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    nameRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    lastnameRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    idcardRules: [
      (v) => !!v || 'ยังไม่ได้ระบุข้อมูล',
      (v) =>
        (v && v.length >= 13 && v && v.length < 14) ||
        'เลขประจำตัวประชาชนไม่เกิน 13 หลัก',
    ],
    birthRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    ageRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    telRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    addressRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    roadRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    soiRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    mooRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    subdistrictRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    districtRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    provinceRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    redaddressRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    redaddress_otherRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    contactRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
    contact_otherRules: [(v) => !!v || 'ยังไม่ได้ระบุข้อมูล'],
  }),

  methods: {
    checkred() {
      if (this.redaddress == 'Y') {
        this.redDisable = false
      } else if (this.redaddress == 'Y') {
        this.redDisable = true
        this.redaddress_other = ''
      } else if (this.redaddress === null) {
        this.redDisable = true
        this.redaddress_other = ''
      }
    },
    checkcontact() {
      if (this.contact == 'Y') {
        this.contactDisable = false
      } else if (this.contact == 'Y') {
        this.contactDisable = true
        this.contact_other = ''
      } else if (this.contact === null) {
        this.contactDisable = true
        this.contact_other = ''
      }
    },
    submitForm() {
      // this.$refs.form.validate()
      const isValid = this.$refs.form.validate()
      if (!isValid) {
        this.$swal({
          title: 'ไม่สามารถเพิ่มข้อมูลได้',
          text: 'ยังระบุข้อมูลไม่ครบ',
          icon: 'error',
          confirmButtonText: 'ตกลง',
        })
        // this.$refs.form.resetValidation()
      } else {
        this.pui_add()
      }
    },

    //add pui add
    async pui_add() {
      await axios
        .post(`${this.$axios.defaults.baseURL}pui_add.php`, {
          prename: this.prename,
          name: this.name,
          lastname: this.lastname,
          idcard: this.idcard,
          birth: this.birth,
          age: this.age,
          tel: this.tel,
          address: this.address,
          road: this.road,
          soi: this.soi,
          moo: this.moo,
          subdistrict: this.subdistrict,
          district: this.district,
          province: this.province,
          redaddress: this.redaddress,
          redaddress_other: this.redaddress_other,
          contact: this.contact,
          contact_other: this.contact_other,
        })
        .then((response) => {
          this.message = response.data
          if (this.message[0].message === 'เพิ่มข้อมูลสำเร็จ') {
            this.$swal({
              title: 'เพิ่มข้อมูลสำเร็จ',
              text:
                'เราได้รับข้อมูลของท่านเรียบร้อยแล้วโปรดรอเจ้าหน้าที่ติดต่อกลับ',
              icon: 'success',
              confirmButtonText: 'ตกลง',
            })
            this.clearform()
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
    clearform() {
      this.prename = ''
      this.name = ''
      this.lastname = ''
      this.idcard = ''
      this.birth = ''
      this.age = ''
      this.tel = ''
      this.address = ''
      this.road = ''
      this.soi = ''
      this.moo = ''
      this.subdistrict = ''
      this.district = ''
      this.province = ''
      this.redaddress = ''
      this.redaddress_other = ''
      this.contact = ''
      this.contact_other = ''
      this.$refs.form.reset()
      window.scrollTo(0, 0)
    },
  },
}
</script>
<style>
html {
  font-family: 'Prompt';
}
</style>
