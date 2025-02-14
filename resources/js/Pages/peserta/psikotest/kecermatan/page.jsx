// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
// import {
//     checkCompatibility,
//     readPertanyaan,
//     readSoalJawaban,
//     readKunciJawaban,
// } from '@/indexedDB/db';
import Layout from '@/Layouts/layout';
import { useRouter } from 'next/navigation';
import axios from 'axios';
import * as React from 'react';

import PropTypes from 'prop-types';
import Button from '@mui/material/Button';
import Radio from '@mui/material/Radio';
import RadioGroup from '@mui/material/RadioGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import FormControl from '@mui/material/FormControl';
import CircularProgress from '@mui/material/CircularProgress';
import debounce from 'lodash.debounce';

import NavigateNextIcon from '@mui/icons-material/NavigateNext';

import Swal from 'sweetalert2';
import Appbarpeserta from '@/components/peserta/Appbarpeserta';
import Myhelmet from '@/components/Myhelmet';
import NavBreadcrumb from '@/components/NavBreadcrumb';
import Footer from '@/components/Footer';

import { readable, random } from '@/libraries/myfunction';
import DOMPurify from 'dompurify';

export default function PesertaPsikotestKecermatan(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [sessionID, setSessionID] = React.useState(parseInt(sessionStorage.getItem('sesi_psikotest_kecermatan')) || 1); // Session ID dimulai dari 1
    // const [safeID, setSafeID] = React.useState(sessionID);
    // const safeID = DOMPurify.sanitize(sessionID);
    const [dataPertanyaan, setDataPertanyaan] = React.useState([]);
    const [dataSoal, setDataSoal] = React.useState([]);
    const [dataJawaban, setDataJawaban] = React.useState([]);
    const [dataSoalJawaban, setDataSoalJawaban] = React.useState([]);
    const [variabel, setVariabel] = React.useState(0);
    const [timeLeft, setTimeLeft] = React.useState();
    const [loading, setLoading] = React.useState(false);
    const [loadingTimer, setLoadingTimer] = React.useState(false);
    const [isDoTest, setIsDoTest] = React.useState(false);

    const [jawabanUser, setJawabanUser] = React.useState({});
    const [nilaiTotal, setNilaiTotal] = React.useState(0);
    const nilaiTotalRef = React.useRef(nilaiTotal);

    const handleChange_nilaiTotal = React.useCallback((event, index, kuncijawaban) => {
        const value = parseInt(event.target.value);
        console.info('handleChange_nilaiTotal: value', value);

        const correctAnswer = parseInt(kuncijawaban);
        // const correctAnswer = parseInt(kuncijawaban);
        console.info('handleChange_nilaiTotal: correctAnswer', correctAnswer);

        // Update jawabanUser untuk setiap perubahan
        setJawabanUser(prevjawabanuser => {
            const newAnswers = { ...prevjawabanuser, [index]: value };
            // Update nilaiTotal berdasarkan jawaban yang benar atau salah
            console.info('jawabanUser', jawabanUser);
            console.info('prevjawabanuser', prevjawabanuser);
            return newAnswers;
        });

        /**
        setNilaiTotal(prevnilaitotal => {
            if (value === correctAnswer) {
                const res = prevnilaitotal + 1; // Menambahkan 1 jika jawabannya benar
                nilaiTotalRef.current = res;
                sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, nilaiTotalRef.current);
                console.info('nilaiTotalRef', nilaiTotalRef);
                console.info('jawaban benar', res);
                return res;
            } else {
                // const res =  prev > 0 ? prev - 1 : 0; // Mengurangi 1 jika jawabannya salah, tapi tidak kurang dari 0
                const res = prevnilaitotal - 0; // Ketika jawaban salah, nilai tidak berkurang maupun bertambah
                console.info('jawaban salah', res);
                return res;
            }
        });
        */

        setNilaiTotal(prevnilaitotal => {
            console.log(`jawabanUser${index}`, jawabanUser);
            if(jawabanUser[index]) { //? Mengecek jika jawabanUser sudah tersedia atau belum
                //? jika ya
                if(value === correctAnswer) { //? ketika jawaban benar
                    const res = prevnilaitotal + 1; // Bertambah 1
                    nilaiTotalRef.current = res;
                    sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, nilaiTotalRef.current);
                    // console.info('nilaiTotalRef', nilaiTotalRef);
                    console.info('jawaban benar', res);
                    return res;
                }
                else { //? ketika jawaban salah
                    const res = prevnilaitotal - 1; //? Berkurang 1
                    console.info('jawaban salah', res);
                    return res;
                    //? alasan karena ketika user bermain curang maka bagian ini tertrigger ketika user  hanya memindahkan radio button saja.
                }
            }
            else {
                //? jika tidak
                if (value === correctAnswer) { // ketika jawaban benar
                    const res = prevnilaitotal + 1; // bertambah 1
                    nilaiTotalRef.current = res;
                    sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, nilaiTotalRef.current);
                    // console.info('nilaiTotalRef', nilaiTotalRef);
                    console.info('jawaban benar', res);
                    return res;
                } else { //? ketika jawaban salah
                    const res = prevnilaitotal - 0; //? nilai tidak bertambah maupun berkurang
                    console.info('jawaban salah', res);
                    return res;
                }
            }
            //? tujuannya untuk menghindari kecurangan.
        });

        // nilaiTotalRef.current = nilaiTotal;
        // console.info('handleChange_nilaiTotal: jawabanUser', jawabanUser);
        // console.info('handleChange_nilaiTotal: nilaiTotal', nilaiTotal);
    }); // => "[]" dihapus karena tidak terpakai

    // Mendapatkan data soal dan jawaban
    const getData = async () => {
        setIsDoTest(false);
        setLoading(true);
        try {
            setLoadingTimer(true);
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken1 = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response_pertanyaan = await axios.get(`/api/psikotest/kecermatan/pertanyaan/${sessionID}`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'XSRF-TOKEN': csrfToken1,
                    'Content-Type': 'application/json',
                    'tokenlogin': random('combwisp', 50),
                    'email' : DOMPurify.sanitize(localStorage.getItem('email')),
                    '--unique--': 'I am unique!',
                    'isvalid': 'VALID!',
                    'isallowed': true,
                    'key': 'key',
                    'values': 'values',
                    'isdumb': 'no',
                    'challenger': 'of course',
                    'pranked': 'absolutely'
                }
            }).catch(function (err1) {
                console.log('error response_pertanyaan', err1);
            });
            const csrfToken2 = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response_soaljawaban = await axios.get(`/api/psikotest/kecermatan/soaljawaban/${sessionID}`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'XSRF-TOKEN': csrfToken2,
                    'Content-Type': 'application/json',
                    'tokenlogin': random('combwisp', 50),
                    'email' : DOMPurify.sanitize(localStorage.getItem('email')),
                    '--unique--': 'I am unique!',
                    'isvalid': 'VALID!',
                    'isallowed': true,
                    'key': 'key',
                    'values': 'values',
                    'isdumb': 'no',
                    'challenger': 'of course',
                    'pranked': 'absolutely'
                }
            }).catch(function (err2) {
                console.log('error response_soaljawaban', err2);
            });

            console.info('response_pertanyaan', response_pertanyaan);
            setDataPertanyaan(response_pertanyaan.data[0]);

            console.info('response_soaljawaban', response_soaljawaban);
            setDataSoalJawaban(response_soaljawaban.data);

            setJawabanUser({});
            setNilaiTotal(0);
            sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, 0);
            sessionStorage.setItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi${sessionID}`, 0);

            console.info('dataVariabel', props.dataVariabel);
            setVariabel(props.dataVariabel[0].values);
            setTimeLeft(props.dataVariabel[0].values);
            setLoadingTimer(false);
        }
        catch (error) {
            console.error('getData-error:', error);
        }
        setLoading(false);
        setIsDoTest(true);
    }

    // Format waktu menjadi menit:detik
    const formatTime = (time) => {
        const minutes = Math.floor(time / parseInt(variabel));
        const seconds = time % parseInt(variabel);
        return `${minutes} menit ${seconds} detik`;
    };

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        if(parseInt(sessionID) > 5) {
            submit();
        }
        else {
            getData();
            if(isDoTest) {
                let hasUpdatedSessionID = false;
                const interval = setInterval(() => {
                    setTimeLeft((prevTime) => {
                        if (prevTime <= 0 && !hasUpdatedSessionID) {
                            setSessionID((prevSessionID) => {
                                const nextSessionID = prevSessionID + 1;
                                sessionStorage.setItem('sesi_psikotest_kecermatan', nextSessionID);
                                return nextSessionID;
                            });
                            hasUpdatedSessionID = true;
                            clearInterval(interval);
                            // Menyimpan nilaiTotal setelah interval selesai dengan sedikit penundaan
                            setTimeout(() => {
                                if (sessionID > 5) {
                                    submit();
                                } else {
                                    // router.push(`/peserta/psikotest/kecermatan/`);
                                    window.location.reload();
                                    // window.location.href = `/peserta/psikotest/kecermatan/${sessionID}`;
                                }
                            }, 60000); // Menunda penyimpanan nilaiTotal beberapa detik
                        }
                        let res = prevTime - 1;
                        sessionStorage.setItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi${sessionID}`, res);
                        return res;
                    });
                }, 1000);
                return () => clearInterval(interval);
            }
        }
        const handleKeydown = (e) => {
            if ((e.key === 'F5') || (e.ctrlKey && e.key === 'r')) {
                e.preventDefault();
                alert('Refresh telah dinonaktifkan!');
            }
        };
        window.addEventListener('keydown', handleKeydown);
        return () => {
            window.removeEventListener('keydown', handleKeydown);
        };
    }, [sessionID, isDoTest, nilaiTotalRef]);

    const MemoSoal = React.memo(({ soal1, soal2, soal3, soal4 }) => {
        return(
            <div className='text-center'>
                <span className="mr-4">{soal1}</span>
                <span className="mr-4">{soal2}</span>
                <span className="mr-4">{soal3}</span>
                <span className="mr-4">{soal4}</span>
            </div>
        )
    });

    const MemoRadioGroup_Jawaban = React.memo(({ index }) => {
        return (
            <RadioGroup
                row
                aria-labelledby="demo-row-radio-buttons-group-label"
                name="row-radio-buttons-group"
                value={jawabanUser[index] || ''}
                onChange={(event) => handleChange_nilaiTotal(event, index, dataJawaban[index].kunci_jawaban)}
            >
                <FormControlLabel value={dataPertanyaan.nilai_A} control={<Radio />} label="A" />
                <FormControlLabel value={dataPertanyaan.nilai_B} control={<Radio />} label="B" />
                <FormControlLabel value={dataPertanyaan.nilai_C} control={<Radio />} label="C" />
                <FormControlLabel value={dataPertanyaan.nilai_D} control={<Radio />} label="D" />
                <FormControlLabel value={dataPertanyaan.nilai_E} control={<Radio />} label="E" />
            </RadioGroup>
        );
    }, []);

    const MemoHelmet = React.memo(function Memo() {
        return(
            <Myhelmet
                title={props.title}
                pathURL={props.pathURL}
                robots={props.robots}
                onetime={props.onetime}
            />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Peserta / Psikotest / Kecermatan`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer />
        );
    });

    const submit = async() => {
        try {
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.post(`/api/peserta-hasil-tes/${parseInt(DOMPurify.sanitize(sessionStorage.getItem(`id_peserta_psikotest`)))}`, {
                hasilnilai_kolom_1: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom1`))),
                hasilnilai_kolom_2: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom2`))),
                hasilnilai_kolom_3: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom3`))),
                hasilnilai_kolom_4: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom4`))),
                hasilnilai_kolom_5: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom5`)))
            }, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'tokenlogin': random('combwisp', 50),
                }
            });

            console.info('response', response);
            if(parseInt(response.data.success)) {
                sessionStorage.removeItem('sesi_psikotest_kecermatan');
                // router.push(`/peserta/psikotest/kecermatan/hasil?identitas=${sessionStorage.getItem('no_identitas_peserta_psikotest')}&tgl_tes=${localStorage.getItem('tgl_tes_peserta_psikotest')}`);
                window.location.href = `/peserta/psikotest/kecermatan/hasil/${sessionStorage.getItem('no_identitas_peserta_psikotest')}/${localStorage.getItem('tgl_tes_peserta_psikotest')}`;
            }
            console.info('Tidak dapat menyimpan data sesi');
        }
        catch(err) {
            console.info('Terjadi Error PesertaPsikotestKecermatan-submit:', err);
        }
    }

    const onNextSession = (e) => {
        e.preventDefault();
        setSessionID((prevSessionID) => {
            const nextSessionID = prevSessionID + 1;
            sessionStorage.setItem('sesi_psikotest_kecermatan', nextSessionID);
            return nextSessionID;
        });
        console.info('sessionID', parseInt(sessionID));
        // router.push(`/peserta/psikotest/kecermatan/`);
        window.location.reload();
        // window.location.href = `/peserta/psikotest/kecermatan/${sessionID}`;
    }

    return (
    <Layout>
        <MemoHelmet />
        <MemoNavBreadcrumb />
        <div className={`text-${textColor}`}>
            <h1 className='hidden'>Halaman Psikotest Kecermatan Peserta</h1>
            {loading ? (
                <h2 className={`text-center p-8 text-${textColor}`}>
                    <p><span className='font-bold text-2lg'>
                        Sedang memuat data... Mohon Harap Tunggu...
                    </span></p>
                    <CircularProgress color="info" size={50} />
                </h2>
            ) : (
                sessionID > 5 ? (
                    <h2 className='text-center p-8'>
                        <p><span className='font-bold text-2lg'>
                            Tes Telah Berakhir!<br/>
                            Harap Tunggu!<br/>
                            Sedang Menyimpan Data Jawaban Anda...<br/>
                            Setelah Menyimpan Sistem Akan Pindah Ke Halaman Hasil..
                        </span></p>
                        <CircularProgress color="info" size={50} />
                    </h2>
                ) : (
                    <div className="text-center p-8">
                        {loadingTimer ? (
                            <h2 className='text-center'>
                                <p><span className='font-bold text-2lg'>
                                    Sedang memuat data... Mohon Harap Tunggu...
                                </span></p>
                                <CircularProgress color="info" size={50} />
                            </h2>
                        ) : (
                            <>
                                <Appbarpeserta
                                    kolom_x={dataPertanyaan.kolom_x}
                                    timer={formatTime(timeLeft)}
                                    soalA={dataPertanyaan.nilai_A}
                                    soalB={dataPertanyaan.nilai_B}
                                    soalC={dataPertanyaan.nilai_C}
                                    soalD={dataPertanyaan.nilai_D}
                                    soalE={dataPertanyaan.nilai_E}
                                />
                                <div className={`mt-12`}>
                                    <h2 className='hidden'>Soal Psikotest Kecermatan {dataPertanyaan.kolom_x}</h2>
                                    <FormControl>
                                        {dataSoalJawaban.map((data, index) => (
                                            <div className="border-4 mt-4 rounded-lg w-full border-black p-2 content-center bg-gray-400" id={`row${index}`} key={index}>
                                                <MemoSoal
                                                    soal1={data.soal_jawaban.soal[0][0]}
                                                    soal2={data.soal_jawaban.soal[0][1]}
                                                    soal3={data.soal_jawaban.soal[0][2]}
                                                    soal4={data.soal_jawaban.soal[0][3]}
                                                />
                                                <RadioGroup
                                                    row
                                                    aria-labelledby="demo-row-radio-buttons-group-label"
                                                    name="row-radio-buttons-group"
                                                    value={jawabanUser[index] || ''}
                                                    onChange={(event) => handleChange_nilaiTotal(event, index, data.soal_jawaban.jawaban)}
                                                >
                                                    <FormControlLabel value={dataPertanyaan.nilai_A} control={<Radio />} label="A" />
                                                    <FormControlLabel value={dataPertanyaan.nilai_B} control={<Radio />} label="B" />
                                                    <FormControlLabel value={dataPertanyaan.nilai_C} control={<Radio />} label="C" />
                                                    <FormControlLabel value={dataPertanyaan.nilai_D} control={<Radio />} label="D" />
                                                    <FormControlLabel value={dataPertanyaan.nilai_E} control={<Radio />} label="E" />
                                                </RadioGroup>
                                            </div>
                                        ))
                                        }
                                    </FormControl>
                                </div>
                                <div className={`mt-4 border-t border-${borderColor}`}>
                                    <Button variant="contained" size="large" fullWidth
                                            color="secondary" title='Sesi Selanjutnya'
                                            onClick={(e) => onNextSession(e)}
                                            sx={{ marginTop: '10px' }}
                                            type="button" endIcon={<NavigateNextIcon />}
                                    >
                                        Sesi Selanjutnya
                                    </Button>
                                </div>
                            </>
                        )}
                    </div>
                )
            )}
        </div>
        <MemoFooter />
    </Layout>
    );
}