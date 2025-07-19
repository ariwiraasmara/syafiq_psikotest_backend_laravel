// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layout from '@/Layouts/layout.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';

import Button from '@mui/material/Button';
import Radio from '@mui/material/Radio';
import RadioGroup from '@mui/material/RadioGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import FormControl from '@mui/material/FormControl';
import CircularProgress from '@mui/material/CircularProgress';

import NavigateNextIcon from '@mui/icons-material/NavigateNext';

import Swal from 'sweetalert2';
import Appbarpeserta from '@/components/peserta/Appbarpeserta.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import DOMPurify from 'dompurify';

interface PesertaPsikotestKecermatan {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
    variabel: string;
    dataKolomPertanyaan: any;
    dataKecermatanSoal: any;
    sessionID: string;
    path: string;
    domain: string;
}

PesertaPsikotestKecermatan.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    variabel: PropTypes.string,
    dataKolomPertanyaan: PropTypes.any,
    dataKecermatanSoal: PropTypes.any,
    sessionID: PropTypes.string,
    path: PropTypes.string,
    domain: PropTypes.string,
};

export default function PesertaPsikotestKecermatan(props: PesertaPsikotestKecermatan) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    let sessionID: number = parseInt(props.sessionID.toString()) || 1;
    // const [sessionID, setSessionID] = React.useState<number>(1);
    const [dataPertanyaan, setDataPertanyaan] = React.useState([]);
    const [dataSoal, setDataSoal] = React.useState<any>([]);
    const [dataJawaban, setDataJawaban] = React.useState<any>([]);
    const [dataSoalJawaban, setDataSoalJawaban] = React.useState<any>([]);
    const [variabel, setVariabel] = React.useState<number>(0);
    const [timeLeft, setTimeLeft] = React.useState<number>();
    const [loading, setLoading] = React.useState<boolean>(false);
    const [loadingTimer, setLoadingTimer] = React.useState<boolean>(false);
    const [isDoTest, setIsDoTest] = React.useState<boolean>(false);
    let interval: any;

    const [jawabanUser, setJawabanUser] = React.useState<any>({});
    const [nilaiTotal, setNilaiTotal] = React.useState(0);
    const nilaiTotalRef = React.useRef(nilaiTotal);

    const styledRadioButton: any = {
        border: '2px solid #fff'
    }

    const handleChange_nilaiTotal = React.useCallback((event, index, kuncijawaban) => {
        const value = parseInt(event.target.value);
        console.info('handleChange_nilaiTotal: value', value);

        const correctAnswer = parseInt(kuncijawaban);
        // const correctAnswer = parseInt(kuncijawaban);
        console.info('handleChange_nilaiTotal: correctAnswer', correctAnswer);

        // Update jawabanUser untuk setiap perubahan
        setJawabanUser((prevjawabanuser: any) => {
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

        setNilaiTotal((prevnilaitotal: any) => {
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
            // console.info('response_pertanyaan', props.dataKolomPertanyaan[0]);
            setDataPertanyaan(props.dataKolomPertanyaan[0]);

            // console.info('response_soaljawaban', props.dataKecermatanSoal);
            setDataSoalJawaban(props.dataKecermatanSoal);

            setJawabanUser({});
            setNilaiTotal(0);
            // setSessionID(parseInt(props.sessionID));
            sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, 0);
            sessionStorage.setItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi${sessionID}`, 0);

            // console.info('dataVariabel', props.variabel);
            setVariabel(parseInt(props.variabel.toString()));
            setTimeLeft(parseInt(props.variabel.toString()));
            setLoadingTimer(false);
        }
        catch (error) {
            console.error('getData-error:', error);
        }
        setLoading(false);
        setIsDoTest(true);
    }

    // Format waktu menjadi menit:detik
    const formatTime = (time: any) => {
        const minutes = Math.floor(time / parseInt(props.variabel.toString()));
        const seconds = time % parseInt(props.variabel.toString());
        return `${minutes} menit ${seconds} detik`;
    };

    const onNextSession = (e: any) => {
        // e.preventDefault();
        sessionID++;
        sessionStorage.setItem('sesi_psikotest_kecermatan', sessionID);
        // console.info('sessionID', sessionID);
        clearInterval(interval);

        if(sessionID > 5) {
            submit();
        }
        else {
            localStorage.setItem('sesi_psikotest_kecermatan', sessionID);
            sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, 0);
            window.location.href = `/peserta/psikotest/kecermatan/${sessionID}`;
        }
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        if(sessionID > 5) {
            submit();
        }
        else {
            getData();
            if(isDoTest) {
                let hasUpdatedSessionID = false;
                interval = setInterval(() => {
                    setTimeLeft((prevTime: any) => {
                        if (prevTime <= 0 && !hasUpdatedSessionID) {
                            sessionID++;
                            sessionStorage.setItem('sesi_psikotest_kecermatan', sessionID);
                            hasUpdatedSessionID = true;
                            clearInterval(interval);
                            // Menyimpan nilaiTotal setelah interval selesai dengan sedikit penundaan
                            setTimeout((e: any) => {
                                onNextSession(e);
                            }, 3000); // Menunda penyimpanan nilaiTotal selama 3 detik
                        }
                        let res = Math.max(prevTime - 1, 0);
                        let waktupengerjaan = variabel - res;
                        sessionStorage.setItem(`waktupengerjaan_kolom_${sessionID}`, waktupengerjaan);
                        sessionStorage.setItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi${sessionID}`, res);
                        return res;
                    });
                }, 1000);
                return () => clearInterval(interval);
            }
        }
        
    }, [sessionID, isDoTest, nilaiTotalRef]);

    document.addEventListener('keydown', (e) => {
        const handlePreventRefresh = (e: any) => {
            if ((e.key === 'F5') || (e.ctrlKey && e.key === 'r')) {
                e.preventDefault();
                // alert('Refresh telah dinonaktifkan!');
            }
        };
        
        const handlePreventDevTools = (e: any) => {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
                e.preventDefault();
                // alert('Developer Tools telah dinonaktifkan!');
            }
        }

        window.addEventListener('keydown', handlePreventRefresh);
        window.addEventListener('keydown', handlePreventDevTools);

        let devtoolsOpen = false;
        const threshold = 160;
        const checkDevTools = () => {
            const widthThreshold = window.outerWidth - window.innerWidth > threshold;
            const heightThreshold = window.outerHeight - window.innerHeight > threshold;
            if (widthThreshold || heightThreshold) {
                if (!devtoolsOpen) {
                    devtoolsOpen = true;
                    alert('Developer tools are open!');
                }
            } else {
                devtoolsOpen = false;
            }
        };

        setInterval(checkDevTools, 1000);

        return () => {
            window.removeEventListener('keydown', handlePreventRefresh);
            window.removeEventListener('keydown', handlePreventDevTools);
        };
    });

    const MemoSoal = React.memo(({ soal1, soal2, soal3, soal4 }) => {
        return(
            <div className='text-center'>
                <span className="mr-4">{soal1}</span>
                <span className="mr-4">{soal2}</span>
                <span className="mr-4">{soal3}</span>
                <span className="mr-4">{soal4}</span>
                <span className="font-bold">.....</span>
            </div>
        )
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Peserta / Psikotest / Kecermatan`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={''} otherCSS={''} />
        );
    });

    const submit = async() => {
        try {
            const hasilnilai_kolom_1: number = parseInt(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom1`));
            const hasilnilai_kolom_2: number = parseInt(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom2`));
            const hasilnilai_kolom_3: number = parseInt(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom3`));
            const hasilnilai_kolom_4: number = parseInt(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom4`));
            const hasilnilai_kolom_5: number = parseInt(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom5`));
            const waktupengerjaan_kolom_1: number = parseInt(sessionStorage.getItem(`waktupengerjaan_kolom_1`));
            const waktupengerjaan_kolom_2: number = parseInt(sessionStorage.getItem(`waktupengerjaan_kolom_2`));
            const waktupengerjaan_kolom_3: number = parseInt(sessionStorage.getItem(`waktupengerjaan_kolom_3`));
            const waktupengerjaan_kolom_4: number = parseInt(sessionStorage.getItem(`waktupengerjaan_kolom_4`));
            const waktupengerjaan_kolom_5: number = parseInt(sessionStorage.getItem(`waktupengerjaan_kolom_5`));

            const idpeserta: string = DOMPurify.sanitize(sessionStorage.getItem(`id_peserta_psikotest`));
            const noidentitas: string = DOMPurify.sanitize(sessionStorage.getItem(`no_identitas_peserta_psikotest`));
            
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.post(`/api/peserta-hasil-tes/${idpeserta}/${noidentitas}`, {
                // unique: '{{ $unique; }}',
                hasilnilai_kolom_1: hasilnilai_kolom_1,
                waktupengerjaan_kolom_1: waktupengerjaan_kolom_1,
                //
                hasilnilai_kolom_2: hasilnilai_kolom_2,
                waktupengerjaan_kolom_2: waktupengerjaan_kolom_2,
                //
                hasilnilai_kolom_3: hasilnilai_kolom_3,
                waktupengerjaan_kolom_3: waktupengerjaan_kolom_3,
                //
                hasilnilai_kolom_4: hasilnilai_kolom_4,
                waktupengerjaan_kolom_4: waktupengerjaan_kolom_4,
                //
                hasilnilai_kolom_5: hasilnilai_kolom_5,
                waktupengerjaan_kolom_5: waktupengerjaan_kolom_5,
            }, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'tokenlogin': props.unique,
                }
            });

            // console.info('response', response);
            if(response.data.success) {
                const noidentitas: string = response.data.no_identitas;
                const tgl_tes: any = localStorage.getItem('tgl_tes_peserta_psikotest');
                sessionStorage.removeItem('sesi_psikotest_kecermatan');
                window.location.href = `/peserta/psikotest/kecermatan/hasil/${noidentitas}/${tgl_tes}`;
            }
            else {
                console.info('Tidak dapat menyimpan data sesi');
            }
        }
        catch(err) {
            console.info('Terjadi Error PesertaPsikotestKecermatan-submit:', err);
        }
    }

    return (
        <Layout>
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
                        <div className="text-center">
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
                                        data={dataPertanyaan}
                                        timer={formatTime(timeLeft)}
                                    />
                                    <div className={`mt-32`}>
                                        <h2 className='hidden'>Soal Psikotest Kecermatan {dataPertanyaan.kolom_x}</h2>
                                        <div className="mt-4 font-bold underline text-lg text-center">Kerjakanlah Soal-Soal ini. Cocokkan dan isi yang tidak ada.</div>
                                        <FormControl>
                                            {dataSoalJawaban.map((data: any, index: number) => (
                                                <div className="mt-6 rounded-lg w-full p-4 content-center bg-gray-400 shadow-2xl text-white" id={`row${index}`} key={index}>
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
                                                        onChange={(event: any) => handleChange_nilaiTotal(event, index, data.soal_jawaban.jawaban)}
                                                    >
                                                        <FormControlLabel value={dataPertanyaan.nilai_A} control={<Radio />} label="A"  />
                                                        <FormControlLabel value={dataPertanyaan.nilai_B} control={<Radio />} label="B"  />
                                                        <FormControlLabel value={dataPertanyaan.nilai_C} control={<Radio />} label="C"  />
                                                        <FormControlLabel value={dataPertanyaan.nilai_D} control={<Radio />} label="D"  />
                                                        <FormControlLabel value={dataPertanyaan.nilai_E} control={<Radio />} label="E"  />
                                                    </RadioGroup>
                                                </div>
                                            ))
                                            }
                                        </FormControl>
                                    </div>
                                    <div className={`mt-6 p-4 border-t border-black`}>
                                        <Button variant="contained" size="large" fullWidth
                                                color="secondary" title='Sesi Selanjutnya'
                                                onClick={(e) => onNextSession(e)}
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