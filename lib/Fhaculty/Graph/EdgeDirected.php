<?php

namespace Fhaculty\Graph;

class EdgeDirected extends Edge{
    /**
     * source/start vertex
     * 
     * @var Vertex
     */
    private $from;
    
    /**
     * target/end vertex
     * 
     * @var Vertex
     */
    private $to;

    /**
     * creats a new Edge
     *
     * @param Vertex $from start/source Vertex
     * @param Vertex $to   end/target Vertex
     */
    public function __construct(Vertex $from,Vertex $to){
        $this->from = $from;
        $this->to = $to;
    }
    
    public function getVerticesTarget(){
        return array($this->to);
    }
    
    public function getVerticesStart(){
        return array($this->from);
    }
    
    public function getVertices(){
        return array($this->from,$this->to);
    }
    
    /**
     * get end/target vertex
     * 
     * @return Vertex
     */
    public function getVertexEnd(){
        return $this->to;
    }
    
    /**
     * get start vertex
     * 
     * @return Vertex
     */
    public function getVertexStart(){
        return $this->from;
    }
    
    public function toString(){
        return $this->from->getId()." -> ".$this->to->getId()." Weight: ".$this->weight;
    }
    
    public function isConnection(Vertex $from,Vertex $to){
        return ($this->to === $to && $this->from === $from);
    }
    
    public function isLoop(){
        return ($this->to === $this->from);
    }
    
    public function getVertexToFrom(Vertex $startVertex){
        if ($this->from !== $startVertex){
            throw new Exception\InvalidArgumentException('Invalid start vertex');
        }
        return $this->to;
    }

    public function getVertexFromTo(Vertex $endVertex){
        if ($this->to !== $endVertex){
            throw new Exception\InvalidArgumentException('Invalid end vertex');
        }
        return $this->from;
    }
    
    public function hasVertexStart(Vertex $startVertex){
        return ($this->from === $startVertex);
    }
    
    public function hasVertexTarget(Vertex $targetVertex){
        return ($this->to === $targetVertex);
    }
    
    public function hasEdgeParallel(){
        foreach($this->from->getEdgesTo($this->to) as $edge){
            if($edge !== $this){
                return true;
            }
        }
        return false;
    }
    
    /**
     * get all edges parallel to this edge (excluding self)
     *
     * @return array[Edge]
     * @throws LogicException
     */
    public function getEdgesParallel(){
    	$edges = $this->from->getEdgesTo($this->to);                            // get all edges between this edge's endpoints
    	
    	$pos = array_search($this,$edges,true);
    	if($pos === false){
    		throw new Exception\LogicException('Internal error: Current edge not found');
    	}
    	 
    	unset($edges[$pos]);                                                   // exclude current edge from parallel edges
    	return array_values($edges);
    }
}
