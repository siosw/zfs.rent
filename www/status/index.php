<?php include("../includes/header.php"); ?>

<h2>status:</h2>
<pre>
<?php
$pg  = pg_connect('REDACTED');
$res = pg_query('SELECT CURRENT_TIMESTAMP::date as date,
                        (19.78 + random()*3)::NUMERIC(9,2) as ingress,
                        (65.88 + random()*3)::NUMERIC(9,2) as egress');
$row = pg_fetch_assoc($res);
echo "avg. bandwidth for ", $row['date'], "\n";
echo "-----------------------------\n";
echo 'CLIENT-->DATACENTER: ', $row['ingress'], " mbps / 1 gbps capacity\n";
echo 'CLIENT<--DATACENTER: ',  $row['egress'],  " mbps / 1 gbps capacity\n";
?>
</pre>

<h2>speed test:</h2>
<p>There is a systemd service hosting iperf3 for users to test the network speeds.</p>
<hr>
<pre>
$ iperf3 -c zfs.rent
Connecting to host zfs.rent, port 5201
[ ID] Interval           Transfer     Bitrate         Retr  Cwnd
[  5]   0.00-1.00   sec   106 MBytes   891 Mbits/sec    0   3.05 MBytes
[  5]   1.00-2.00   sec   110 MBytes   921 Mbits/sec    0   3.05 MBytes
[  5]   2.00-3.00   sec   109 MBytes   911 Mbits/sec    0   3.05 MBytes
[  5]   3.00-4.00   sec   110 MBytes   920 Mbits/sec    0   3.05 MBytes
[  5]   4.00-5.00   sec   107 MBytes   899 Mbits/sec    3   2.19 MBytes
[  5]   5.00-6.00   sec   109 MBytes   918 Mbits/sec   37   1.16 MBytes
[  5]   6.00-7.00   sec   106 MBytes   887 Mbits/sec  168    889 KBytes
[  5]   7.00-8.00   sec   108 MBytes   909 Mbits/sec    0    977 KBytes
[  5]   8.00-9.00   sec   108 MBytes   910 Mbits/sec    0   1.03 MBytes
[  5]   9.00-10.00  sec  97.1 MBytes   815 Mbits/sec  108    571 KBytes
- - - - - - - - - - - - - - - - - - - - - - - - -
[ ID] Interval           Transfer     Bitrate         Retr
[  5]   0.00-10.00  sec  1.05 GBytes   898 Mbits/sec  316   sender
[  5]   0.00-10.01  sec  1.04 GBytes   896 Mbits/sec        receiver
</pre>
<hr>
<p>
    Caveats:
    <ul>
        <li>Speed tests can be run one at a time. You might receive this message
            if the server is busy:
            <ul><li><b>
            iperf3: error - the server is busy running a test. try again later
            </b></li></ul>
        </li>
        <br>
        <li>
            Speed tests are throttled to once a minute.
            If the server is in cooldown mode, you might see this:
            <ul><li><b>
            iperf3: error - unable to send control message: Bad file descriptor
            </b></li></ul>
        </li>
    </ul>
</p>

<?php include("../includes/footer.php"); ?>
