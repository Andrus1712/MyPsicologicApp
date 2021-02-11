<?php

	
class chartkick{

public function LineChart($chart_div,$data,$size='300px'){
	//$data = {"2013-02-10 00:00:00 -0800": 11, "2013-02-11 00:00:00 -0800": 6}
	//$dataArray[]= "\".$dataset[0]." 00:00:00 -0800\":". $dataset[1]
	//$data = implode(",",$dataArray);
	echo "<div class='box-body' id='".$chart_div."' style='height=".$size."'></div>";
	echo "<script>
	new Chartkick.LineChart(".$chart_div.",{".$data."});
	</script>";
}
public function PieChart($chart_div,$data,$size='300px'){
	
	//$data = ["Blueberry", 44],["Strawberry", 23]
	//$dataArray[]= "[\"".$dataset[0]."\", ". $dataset[1]."]"
	//$data = implode(",",$dataArray);
	echo "<div class='' id='".$chart_div."' style='height=".$size."'></div>";
	echo "<script>
	new Chartkick.PieChart(\"".$chart_div."\",[".$data."]);
	</script>";
}
public function ColumnChart($chart_div,$data,$size='300px'){
	
	//$data = ["Blueberry", 44],["Strawberry", 23]
	//$dataArray[]= "[\".$dataset[0]."\", ". $dataset[1]."]"
	//$data = implode(",",$dataArray);
	echo "<div class='box-body' id='".$chart_div."' style='height=".$size."'></div>";
	echo "<script>
	new Chartkick.ColumnChart(".$chart_div.",[".$data."]);
	</script>";
	
}
public function BarChart($chart_div,$data,$size='300px'){
	
	//$data = ["Blueberry", 44],["Strawberry", 23]
	//$dataArray[]= "[\".$dataset[0]."\", ". $dataset[1]."]"
	//$data = implode(",",$dataArray);
	echo "<div class='box-body' id='".$chart_div."' style='height=".$size."'></div>";
	echo "<script>
	new Chartkick.BarChart(".$chart_div.",[".$data."]);
	</script>";
	
}
public function AreaChart($chart_div,$data,$size='300px'){
	//$data = {"2013-02-10 00:00:00 -0800": 11, "2013-02-11 00:00:00 -0800": 6}
	//$dataArray[]= "\".$dataset[0]." 00:00:00 -0800\":". $dataset[1]
	//$data = implode(",",$dataArray);
	echo "<div class='box-body' id='".$chart_div."' style='height=".$size."'></div>";
	echo "<script>
	new Chartkick.AreaChart(".$chart_div.",{".$data."});
	</script>";
}
public function Timeline($chart_div,$data,$size='300px'){
	
	//$data = ["Washington", "1789-04-29", "1797-03-03"]
	//$dataArray[]= "[\".$dataset[0]."\", \"". $dataset[1]."\", \"". $dataset[2]."\"]"
	//$data = implode(",",$dataArray);
	echo "<div class='box-body' id='".$chart_div."' style='height=".$size."'></div>";
	echo "<script>
	new Chartkick.BarChart(".$chart_div.",[".$data."]);
	</script>";
	
}

public function multiLineChart($chart_div,$data,$size='300px'){
	//$data = {"name":"Chart1","data":{"2013-02-10 00:00:00 -0800": 11, "2013-02-11 00:00:00 -0800": 6}}
	//$dataArray[]= "\".$dataset[0]." 00:00:00 -0800\":". $dataset[1]
	//$data = implode(",",$dataArray);
	echo "<div class='box-body' id='".$chart_div."' style='height=".$size."'></div>";
	echo "<script>
	new Chartkick.LineChart(".$chart_div.",[{".$data."}]);
	</script>";
}

} //class

?>